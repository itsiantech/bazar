

<?php $__env->startPush("scripts"); ?>
    <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>
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
                    "id" : <?php echo e($guest->id); ?>,
                    "message" : message,
                    "_token": "<?php echo e(csrf_token()); ?>"
                }
                $.post( "<?php echo e(route('chats.sendMessage')); ?>",data, function( data ) {
                    $msgHistory.append(outgoingMessage)
                    $msgHistory.scrollTop($msgHistory.prop("scrollHeight"));


                });
            }



            Echo.private('guest-room-<?php echo e($guest->id); ?>')
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush("stylesheets"); ?>
    <link href="<?php echo e(asset("css/chat_box.css")); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection("content"); ?>


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
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            </div>
                                            <div class="inbox_chat">
                                                <?php $__empty_1 = true; $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="chat_list active_chat">
                                                    <div class="chat_people">
                                                        <div class="chat_img"><img src="<?php echo e(asset("images/user-profile.png")); ?>" alt="sunil"></div>
                                                        <div class="chat_ib">
                                                            <h5><?php echo e($guest->email != ""?$guest->email:$guest->phone); ?></h5>
                                                            <p> <span class="chat_date"><?php echo e($guest->created_at->format("Y-m-d H:m:s")); ?></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="mesgs" id="msg_history_container">
                                            <div class="msg_history" id="msg_history">

                                                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php if($message->sender_id == $guest->id): ?>

                                                        <div class="incoming_msg">
                                                            <div class="incoming_msg_img"><img src="<?php echo e(asset("images/user-profile.png")); ?>" alt="sunil"></div>
                                                            <div class="received_msg">
                                                                <div class="received_withd_msg">
                                                                    <p><?php echo e($message->message); ?></p>
                                                                    <span class="time_date"><?php echo e($message->created_at->format("Y-m-d H:m:s")); ?></span></div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>

                                                        <div class="outgoing_msg">
                                                            <div class="sent_msg">
                                                                <p><?php echo e($message->message); ?></p>
                                                                <span class="time_date"><?php echo e($message->created_at->format("Y-m-d H:m:s")); ?></span></div>
                                                        </div>

                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                                <?php endif; ?>



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

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/chats/guest_room.blade.php ENDPATH**/ ?>