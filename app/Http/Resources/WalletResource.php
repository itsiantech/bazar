<?php

namespace App\Http\Resources;

use DebugBar\DebugBar;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->walletId,
            'customer_name' => $this->user?$this->user->name:'N/A',
            'balance' => $this->balance,
            'last_updated_at' => $this->updated_at,
            'total_spent' => $this->totalSpent
        ];
    }
}
