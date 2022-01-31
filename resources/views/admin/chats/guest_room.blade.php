@extends("layouts.app")

@push("scripts")
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            var $msgHistory = $('#msg_history');
            $msgHistory.scrollTop($msgHistory.prop("scrollHeight"));
            $("#sendMessage").on("click", function () {
                sendChatMessage()
            })

            $("#msgBoxText").keypress(function(e){
                if(e.which == 13){//Enter key pressed
                    sendChatMessage()
                }
            });

            function sendChatMessage()
            {
                var d = new Date();
                var $msgHistory = $('#msg_history');
                var message = $("#msgBoxText").val()
                if(message == "") return 0

                var outgoingMessage = `<div class="outgoing_msg">
                                            <div class="sent_msg">
                                                <p>${message}</p>
                                                <span class="time_date"> ${d.toLocaleString()}</span>
                                            </div>
                                        </div>`

                $("#msgBoxText").val("")

                var data = {
                    "id" : {{$guest->id}},
                    "message" : message,
                    "_token": "{{csrf_token()}}"
                }
                $.post( "{{route('chats.sendMessage')}}",data, function( data ) {
                    $msgHistory.append(outgoingMessage)
                    $msgHistory.scrollTop($msgHistory.prop("scrollHeight"));


                });
            }



            Echo.private('guest-room-{{$guest->id}}')
                .listen('ChatMessageBroadcast', (e) => {
                    console.log(e)
                    d = new Date()
                    var messageFrom = !!e.data?e.data.messageFrom:"N/A";
                    var incomingMessage = `<div class="incoming_msg">
                                                <div class="incoming_msg_img"><img src="/images/user-profile.png" alt="sunil"></div>
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p>${e.data.message.message}</p>
                                                        <span class="time_date">${d.toLocaleString()}</span></div>
                                                </div>
                                            </div>`
                    var $msgHistory = $('#msg_history');

                    $msgHistory.append(incomingMessage)
                    $msgHistory.scrollTop($msgHistory.prop("scrollHeight"));

                });








        })
    </script>
@endpush

@push("stylesheets")
    <link href="{{asset("css/chat_box.css")}}" rel="stylesheet" type="text/css"/>
@endpush

@section("content")


    <div class="row">
        <div class="col-md-12">

            <div class="app-ticket app-ticket-list">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-body">

                                <div class="messaging">
                                    <div class="inbox_msg">


                                        <div class="inbox_people">
                                            <div class="headind_srch">
                                                <div class="recent_heading">
                                                    <h4>Recent</h4>
                                                </div>
                                                {{--                                                <div class="srch_bar">--}}
                                                {{--                                                    <div class="stylish-input-group">--}}
                                                {{--                                                        <input type="text" class="search-bar" placeholder="Search">--}}
                                                {{--                                                        <span class="input-group-addon">--}}
                                                {{--                                                            <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>--}}
                                                {{--                                                        </span></div>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                            <div class="inbox_chat">
                                                @forelse($guests as $guest)
                                                <div class="chat_list active_chat">
                                                    <div class="chat_people">
                                                        <div class="chat_img"><img src="{{asset("images/user-profile.png")}}" alt="sunil"></div>
                                                        <div class="chat_ib">
                                                            <h5>{{$guest->email != ""?$guest->email:$guest->phone}}</h5>
                                                            <p> <span class="chat_date">{{$guest->created_at->format("Y-m-d H:m:s")}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @empty

                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="mesgs" id="msg_history_container">
                                            <div class="msg_history" id="msg_history">

                                                @forelse($messages as $message)
                                                    @if($message->sender_id == $guest->id)

                                                        <div class="incoming_msg">
                                                            <div class="incoming_msg_img"><img src="{{asset("images/user-profile.png")}}" alt="sunil"></div>
                                                            <div class="received_msg">
                                                                <div class="received_withd_msg">
                                                                    <p>{{$message->message}}</p>
                                                                    <span class="time_date">{{$message->created_at->format("Y-m-d H:m:s")}}</span></div>
                                                            </div>
                                                        </div>
                                                    @else

                                                        <div class="outgoing_msg">
                                                            <div class="sent_msg">
                                                                <p>{{$message->message}}</p>
                                                                <span class="time_date">{{$message->created_at->format("Y-m-d H:m:s")}}</span></div>
                                                        </div>

                                                    @endif
                                                @empty

                                                @endforelse



                                            </div>




                                            <div class="type_msg">
                                                <div class="input_msg_write">
                                                    <input type="text" class="write_msg" id="msgBoxText" value="" placeholder="Type a message"/>
                                                    <button class="msg_send_btn" id="sendMessage" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection
