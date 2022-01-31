<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Packages\Wallet\WalletManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    private $globalObject ;

    function __construct()
    {
        $this->middleware(function($request, $next){
            $this->globalObject = new WalletManager(auth()->user());
            return $next($request);
        });
    }
    public function GetWallet()
    {
        return response(new WalletResource($this->globalObject->GetUserWallet()));
    }
}
