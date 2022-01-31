<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Users\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDeleteRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use phpDocumentor\Reflection\Utils;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout()
    {
        return redirect('/')->with(Auth::logout());
    }



    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }


    public function handleProviderCallback($provider)
    {

        $socialUser = Socialite::driver($provider)->stateless()->user();

        $data = [
            $socialUser->getId(),
            $socialUser->getNickname(),
            $socialUser->getName(),
            $socialUser->getEmail(),
            $socialUser->getAvatar(),
        ];

        $email = $socialUser->getEmail();


        $userByEmailExist = User::where('email', $email)->where('email', '<>', '')->whereNotNull('email')->exists();

        $userByProviderExist = User::where('provider', $provider)->where('provider_id', $socialUser->id)->where('provider_id', '<>', '')->whereNotNull('provider_id')->exists();



        if(!$userByEmailExist && !$userByProviderExist) return $this->RegisterNewSocialUser($socialUser, $provider);

        if($userByProviderExist){
            $user = User::where('provider', $provider)->where('provider_id', $socialUser->id)->where('provider_id', '<>', '')->whereNotNull('provider_id')->first();

            if(!empty($user)) return $this->ReturnExistingUser($user);

            return $this->UnknownErrorResources();
        }

        if($userByEmailExist){
            $user = User::where('email', $email)->where('email', '<>', '')->whereNotNull('email')->first();

            if($user->email == $email) return $this->ReturnExistingUser($user);

            return $this->UnknownErrorResources();
        }

        return $this->RegisterNewSocialUser($socialUser, $provider);

    }


    public function RegisterNewSocialUser($socialUser, $provider)
    {
        $user = User::create($this->GetUserData($socialUser->getName(),$provider,$socialUser->getId(), $socialUser->getEmail()));
        $token = $user->createToken($user->name);
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response(new AuthResource($response), 200);
    }

    public function ReturnExistingUser($user)
    {
        $token = $user->createToken($user->name);
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response(new AuthResource($response), 200);
    }

    public function UnknownErrorResources()
    {
        return [
            'meta' => [
                'error' => true,
                'message' => 'User Email and Provider email not matched but found as duplicate. Unknown type error'
            ]
        ];
    }

    public function DeleteFacebookData($provider)
    {
        $signed_request = $_POST['signed_request'];
        $data = $this->parse_signed_request($signed_request);
        $providerId = $data['user_id'];


        $user = User::where('provider', $provider)->where('provider_id', $providerId)->limit(1)->first();
        if(empty($user))
        {
            return false;
        }

        $confirmation_code = Str::random(20).now()->timestamp; // unique code for the deletion request

        try{
            $expire = now()->add(30, 'day')->timestamp;
            $user->DeletedUser()->create(['confirmation_code' => $confirmation_code, 'expires' => $expire]);

        }catch (\Exception $e){
            Log::alert($e->getMessage());
        }

        $status_url = url("api/deletion/facebook/$confirmation_code/status"); // URL to track the deletion

        $data = array(
            'url' => $status_url,
            'confirmation_code' => $confirmation_code
        );

        return response($data)
            ->header('Content-Type', 'application/json');
    }

    public function DeletedFBUserStatus($provider, $confirmationCode)
    {
        $userDeleteRequest = UserDeleteRequest::where('confirmation_code', $confirmationCode)->limit(1)->first();
        $response =  [
            "algorithm" => null,
            "expires" => null,
            "issued_at" => null,
            "user_id" => null,
        ];

        if(empty($userDeleteRequest)){
            Log::debug("UserDeleteRequest Empty::$confirmationCode");
            return $response;
        }

        $user = $userDeleteRequest->user;

        if(empty($user)){
            Log::debug("User Null::$confirmationCode::Auth/LoginController");
            return $response;
        }

        if($user->provider == $provider){
            $response["algorithm"] = $userDeleteRequest->algorithm;
            $response["expires"] = $userDeleteRequest->expires;
            $response["issued_at"] = $userDeleteRequest->created_at->timestamp;
            $response["user_id"] = $userDeleteRequest->user_id;
        }

        return $response;
    }


    public function GetUserData($name,$provider,$providerId, $email)
    {
        $data['type'] = 'customer';
        $data['name'] = $name;
        $data['password'] = Hash::make('ed'.$provider.$providerId);
        $data['is_verified'] = 1;
        $data['is_activated'] = 1;
        $data['provider']=$provider;
        $data['provider_id']=$providerId;
        $data['email']=$email;
        return $data;
    }


    function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = config('services.facebook.client_secret'); // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

}
