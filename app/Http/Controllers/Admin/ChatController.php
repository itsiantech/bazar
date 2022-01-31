<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatMessageBroadcast;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminChatRequestStore;
use App\Models\Guest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function dashboard()
    {
        $guests = Guest::all();
        return view('admin.chats.dashboard', compact('guests'));
    }


    public function store(AdminChatRequestStore $request)
    {
        $form_data = $request->validated();

        $guest = Guest::findOrFail($form_data['id']);

        $message = Message::create(['sender_id' => auth()->user()->id, 'receiver_id' => $form_data['id'], 'message' => $form_data['message']]);

        $data = [
            'message' => $message,
            'messageFrom' => 'admin'
        ];

        event(new ChatMessageBroadcast($data, 'guest-'.$guest->id, false));

        return [
            'response' => [
                'status' => 200,
                'errors' => [],
            ]
        ];
    }

    public function show($id)
    {
        $guest = Guest::findOrFail($id);

        $guests = Guest::all();
/*
        $guests = Guest::select('guests.id',
            DB::raw("messages.id as mid"),
            'guests.created_at',
            DB::raw("messages.created_at as ca"),
            'messages.message',
            'guests.email',
            'guests.phone'
        )
//        ->join('messages', function ($join) {
//                $join->on('guests.id', '=', 'messages.sender_id')->orOn('guests.id', '=', 'messages.receiver_id')
//                    ->where('messages.created_at','=', "2021-01-30 03:46:37");
////                        DB::raw("(SELECT MAX(created_at) FROM messages)"));
////                    ->where('messages.id',10);
//                    ;
//            })


            ->join('messages', function ($join) {
                $join->on('guests.id', '=', 'messages.sender_id')
                    ->where('messages.created_at','=', "2021-01-30 03:46:37");
                ;
            })
            ->get();
        dd($guests);
*/



        $messages = Message::where('sender_id', $id)->orWhere('receiver_id', $id)->get();

        return view('admin.chats.guest_room', compact('guest', 'messages', 'guests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
