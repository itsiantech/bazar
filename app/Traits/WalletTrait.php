<?php
namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait WalletTrait
{
    public function UserWallet()
    {
        $withdraws =  DB::table('withdraws')
            ->table('tab1')
            ->join('tab2', 'tab1.id', 'tab2.tab1_id') // replace this with the actual foreign key
            ->selectraw('tab1.Amount - tab2.Amount_Run AS amount')
            ->get();

        return $withdraws;

    }

    public function GetRefundAmount()
    {

    }


}