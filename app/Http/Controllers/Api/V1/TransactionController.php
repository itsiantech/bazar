<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionHistoryResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        try
        {
            $histories = new TransactionService($user);

            return new TransactionHistoryResource($histories->getHistory());


        }catch (\Exception $e)
        {
            return [
                'data' => [],
                'status' => $e->getCode()?$e->getCode():500,
                'meta' => [
                    'msg' => $e->getMessage()
                ]
            ];

        }
    }
}
