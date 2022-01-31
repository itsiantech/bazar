<?php


namespace App\Packages\Gateway\Base;


use App\Models\Order;
use App\Packages\Gateway\Contracts\Gateway;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class BKASHBaseGateway implements Gateway
{
    abstract public function processPayment(float $amount, Order $order): string;

    abstract public function ipnListener(array $transaction_data): bool;

    public function getToken()
    {
        if($this->hasToken()) return Cache::get('bkash_id_token');

        if($this->hasRefreshToken())
        {
            return $this->refreshToken(Cache::get('bkash_refresh_token'));
        }

        return $this->grantToken();
    }

    /**
     * @return string
     */
    public function grantToken():string
    {
        try{

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'username' => config('gateway.bkash.username'),
                'password' => config('gateway.bkash.password'),
            ])
                ->post(config('gateway.bkash.base_url')."/tokenized/checkout/token/grant", [
                    'app_key' => config('gateway.bkash.key'),
                    'app_secret' => config('gateway.bkash.secret'),
                ]);


            if($response->status() == 200)
            {
                $body = $response->json();
                Log::info('body', ['body' => $body]);
                return $this->storeToken($body);
            }
            Log::warning('grantToken', [
                'file' => __FILE__,
                'line' => __LINE__,
                'status' => $response->status(),
                'obj' => $response->object(),
            ]);
            return "EMPTY_TOKEN";
        }catch (\Exception $ex){
            Log::error($ex->getMessage(), [
                'error' => $ex,
            ]);
            return "EMPTY_TOKEN";
        }

    }

    /*
     * @return bool
     *
     * */
    public function hasToken():bool
    {
        $token = Cache::get('bkash_id_token');
        return Cache::has('bkash_id_token') && !is_null($token) && $token != 'EMPTY_TOKEN';
    }

    public function hasRefreshToken():bool
    {
        $token = Cache::get('bkash_refresh_token');
        return Cache::has('bkash_refresh_token') && !is_null($token) && $token != 'EMPTY_TOKEN';
    }

    /**
     * @param string $refreshToken
     * @return string
     */
    public function refreshToken(string $refreshToken):string
    {
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'username' => config('gateway.bkash.username'),
                'password' => config('gateway.bkash.password'),
            ])->post(config('gateway.bkash.base_url')."/tokenized/checkout/token/refresh", [
                'app_key' => config('gateway.bkash.key'),
                'app_secret' => config('gateway.bkash.secret'),
                'refresh_token' => $refreshToken,
            ]);

            if($response->status() == 200)
            {
                $body = $response->json();
                return $this->storeToken($body);
            }

            return "EMPTY_TOKEN";

        }catch (\Exception $ex){
            Log::error($ex->getMessage(), [
                'error' => $ex,
            ]);
            return "EMPTY_TOKEN";
        }
    }

    /**
     * @param array $body
     * @return string
     */
    private function storeToken(array $body):string
    {
        Config::set('gateway.bkash_token_life', $body['expires_in']);
        Cache::put('bkash_refresh_token', $body['refresh_token']);
        Cache::put('bkash_expires_in', $body['expires_in'], config('gateway.bkash.token_life'));
        Cache::put('bkash_id_token', $body['id_token'], config('gateway.bkash.token_life'));
        Cache::put('bkash_token_type', $body['token_type'], config('gateway.bkash.token_life'));
        return Cache::get('bkash_id_token');
    }

    public function getCachedData()
    {
        return [
            'id_token' => Cache::get('bkash_id_token'),
            'bkash_refresh_token' => Cache::get('bkash_refresh_token'),
            'bkash_expires_in' => Cache::get('bkash_expires_in'),
            'bkash_id_token' => Cache::get('bkash_id_token'),
            'bkash_token_type' => Cache::get('bkash_token_type'),
        ];
    }

    public function removeCachedData()
    {
        Cache::forget('bkash_id_token');
        Cache::forget('bkash_refresh_token');
        Cache::forget('bkash_expires_in');
        Cache::forget('bkash_id_token');
        Cache::forget('bkash_token_type');
    }
}
