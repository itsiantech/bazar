<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ChatMessageBroadcast;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuestRequestFindOrRegister;
use App\Http\Requests\GuestRequestSendChatMessage;
use App\Models\Guest;
use App\Models\Message;
use Validator;
use Illuminate\Http\Request;

class GuestChatController extends Controller
{
    public function FindGuest(GuestRequestFindOrRegister $request)
    {
        $form_data = $request->validated();

        $guest = $this->CreateGuest($form_data);

        return [
            'response' => [
                'data' => $guest,
                'status' => 200,
                'errors' => [],
            ]
        ];
    }

    public function CreateGuest($form_data)
    {
        $guest = Guest::where('email', $form_data['email'])->orWhere('phone', $form_data['phone'])->first();

        if (empty($guest))
            $guest = Guest::create($form_data);

        return $guest;
    }

    public function GuestSendChatMessage(GuestRequestSendChatMessage $request)
    {

        $data = $request->validated();

        $guest = $this->CreateGuest($data);

        $form_data = ['sender_id' => $guest->id, 'receiver_id' => 0, 'message' => $data['message']];

        $message = Message::create($form_data);

//        dd('guest-room-'.$guest->id);

        try{

            event(new ChatMessageBroadcast([
                'message' => $message,
                'messageFrom' => 'guest'
            ], 'guest-room-'.$guest->id));

        }catch (\Exception $e){
            return [
                'status' => $e->getCode()?$e->getCode():422,
                'errors' => $e->getMessage()
            ];
        }
        return [
            'status' => 200,
            'error' => False
        ];

    }
}
