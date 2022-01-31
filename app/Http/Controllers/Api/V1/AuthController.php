<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\PasswordResetEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegistrationRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \Validator;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    private $smsGatewayUser = "EkhoniD";
    private $smsGatewayPass = "EkhoniD@789";
    private $sender = "EkhoniDrokr";

    public function Login(Request $request)
    {
        $credentials = $request->only('phone', 'password', 'email');
        //dd($this->GenerateOTP());
        if (isset($request->phone)) {
            $user = User::where('phone', $request->phone)->whereNotNull('phone')->where('phone', '<>', '0')->first();

        } else if (isset($request->email)) {

            $user = User::where('email', $request->email)->whereNotNull('email')->where('email', '<>', '')->first();

        }

        if(empty($user))
            return [
                'status' => 401,
                'meta' => [
                    "AuthFailMessage" => "User Not Found"
                ]
        ];

        if($user->is_verified == 0){
            return [
                'status' => 401,
                'user' => $user,
                'is_verified' => 0,
                'meta' => [
                    "AuthFailMessage" => "User is not verified. Verify before proceed"
                ]
            ];
        }

        if (!Hash::check($request->password, $user->password)) {
//            return response([
//                'message' => 'These credentials do not match our records. or you might have not verified your phone !',
//            ]);
            return [
                'status' => 401,
                'meta' => [
                    "AuthFailMessage" => "Maybe your credentials are wrong"
                ]
            ];
        }

        $user->tokens()->where('name', $user->name)->delete();
        $token = $user->createToken($user->name);

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response(new AuthResource($response), 200);

    }

    public function Register(UserRegistrationRequest $request)
    {
        // $request->request->remove('gender');
        // return $request->only(['email','name','password','password_confirmation','phone']);
        $message = '';

        $userObj = new User();
        $data = $userObj->GetData($request->all());
        $data = $userObj->GetData($request->only(['email','name','password','password_confirmation','phone']));
        $data['otp'] = $this->GenerateOTP();
        try {
            $user = $userObj->create($data);
            if ($user) {
                return $this->sendSMS($request->phone, $data['otp'], 'We have sent an verification code to your number. Please verify the code to continue');
            }
        } catch (QueryException $ex) {
            return response(['error' => $ex->getMessage()] , 422);
        }
        return response(['error' => "Unable to handle this request !"] , 422);

    }

    public function sendSMS($phone, $otp, $message)
    {
        try{
            if (MessageService::sendSMS($phone, $otp)) {
                return response()->json([
                    'message' => $message,
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'meta' => [
                    'error' => 1,
                    'message' => $e->getMessage()
                ],
            ]);
        }
    }


    public function resendOTP(Request $request)
    {
        $rules = [
            'phone' => 'required|string|max:11'
        ];

        $data = Validator::make($request->all(), $rules)->validate();

        $otp = $this->UserUpdateOtp($data['phone']);

        if($otp){
            return $this->sendSMS($request->phone, $otp, 'We have sent an verification code to your number. Please verify the code to continue');
        }

        return response()->json([
            'message' => 'Unable to Generate OTP',
        ]);

    }




    public function VerifyOTP(Request $request)
    {
        $credentials = $request->only('phone', 'otp');
        $user = User::where('phone', $request->phone)->where('otp', $request->otp)->first();

        if ($user) {
            if ($user->is_verified == 1) {
                return response()->json(['message' => 'Your number is already verified!'], 200);

            }
            if ($user->update(['is_verified' => 1])) {
                return response()->json(['message' => 'Your number verified successfully !'], 200);
            }

        }
        return response()->json(['message' => 'Unable to verify your number'], 400);
    }



    public function UserUpdateOtp($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user) {
            $otp = $this->GenerateOTP();
            $user->update(['otp' => $otp]);
            return $otp;
        }
        return false;
    }

    public function GenerateOTP()
    {
        return "BS" . rand(1000, 9999);

    }


    public function ForgetPassword(Request $request)
    {
        $otp = $this->UserUpdateOtp($request->phone);
        if ($otp)
            return $this->sendSMS($request->phone, $otp, 'We have sent an verification code to your number. Please verify the code to continue');

//        if (MessageService::sendSMS($request->phone, $otp)) {
//                return response()->json([
//                    'message' => 'We have sent an verification code to your number. Please verify the code to continue',
//                ]);
//            }
        return response()->json([
            'message' => 'unable to generate verification code !',
        ]);
    }



    public function Logout()
    {
        //dd(Auth::user());
        if (Auth::user()) {
            Auth::user()->tokens()->delete();
            return response()->json(['message' => 'Logged Out'], 200);

        }

    }

    public function ForgotPasswordChange(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $password = Hash::make($request->password);
        if ($user->update(['password' => $password])) {
            return response([
                'message' => 'Password has been updated.'
            ], 200);
        }
    }

    public function ChangePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'These credentials do not match our records.'
            ], 404);
        } else {
            $password = Hash::make($request->new_password);
            if ($user->update(['password' => $password])) {
                return response([
                    'message' => 'Password has been updated.'
                ], 200);
            }
        }

    }

    public function CreatePasswordResetToken(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response([
                'message' => 'Incorrect email address !'
            ]);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return response(['message' => 'A reset link has been sent to your email address.']);
        } else {
            return response(['message' => 'A Network Error occurred. Please try again..']);
        }
    }

    private function sendResetEmail($email, $token)
    {

        $user = DB::table('users')->where('email', $email)->select('email')->first();

        $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);

        try {
            event(new PasswordResetEvent($link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ResetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'token' => 'required']);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;

        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();

        if (!$tokenData) return view('auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) return response(['message' => 'Email not found']);

        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        //Send Email Reset Success Email
        if ($this->sendSuccessEmail($tokenData->email)) {
            return view('index');
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }

    }


}
