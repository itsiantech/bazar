<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionHistoryResource extends JsonResource
{
    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'type' => $this->type,
                'phone' => $this->phone,
            ],
            'history' => TransactionResource::collection($this->transactions),
            'wallet' => new WalletResource($this->wallet),
        ];
    }
}
