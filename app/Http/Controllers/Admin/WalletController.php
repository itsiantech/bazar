<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')->latest()->get();

        return view('admin.wallets.index', compact('wallets'));
    }

    public function show(Wallet $wallet)
    {
        $transactionHistory = $wallet->load(['transactions' => function($q){
            $q->latest();
        }, 'user', 'user.profile']);

        $wallet->load('user', 'user.profile');

        $transactionHistory = Transaction::with('transactionable')->latest()->get();

        return view('admin.wallets.show',compact('transactionHistory', 'wallet'));
    }
}
