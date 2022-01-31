<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return $this->resource->map(function ($item) {
//            return [
//                'reviewMessage' => $item->review_message,
//                'rating' => $item->rating,
//                'user' => new UserResource($item->user)
//            ];
//        });

        $user = $this->user;

        if(!empty($user)){
            $user = [
                'name' => $user->name,
                'joinDate' => Carbon::parse($user->created_at)->format('d M, Y')
            ];
        }

        return [
            'reviewMessage' => $this->message,
            'rating' => $this->rating,
            'user' => $user
        ];
    }
}
