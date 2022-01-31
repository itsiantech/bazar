

<?php $__env->startPush("stylesheets"); ?>
    <link href="<?php echo e(asset("assets/pages/css/profile.min.css")); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset("assets/apps/css/ticket.min.css")); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush("scripts"); ?>

    <script>

       // Echo.channel('guest-1')
       //     .listen('ChatMessageBroadcast', (e) => {
       //         console.log(e)
       //     });
    </script>

<?php $__env->stopPush(); ?>

<?php $__env->startSection("content"); ?>


    <div class="row">
        <div class="col-md-12">

<!--
            <div class="profile-sidebar">
                &lt;!&ndash; PORTLET MAIN &ndash;&gt;
                <div class="portlet light profile-sidebar-portlet ">
                    &lt;!&ndash; SIDEBAR USERPIC &ndash;&gt;
                    <div class="profile-userpic">
                        <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""></div>
                    &lt;!&ndash; END SIDEBAR USERPIC &ndash;&gt;
                    &lt;!&ndash; SIDEBAR USER TITLE &ndash;&gt;
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> Marcus Doe</div>
                        <div class="profile-usertitle-job"> Developer</div>
                    </div>
                    &lt;!&ndash; END SIDEBAR USER TITLE &ndash;&gt;
                    &lt;!&ndash; SIDEBAR BUTTONS &ndash;&gt;
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                    &lt;!&ndash; END SIDEBAR BUTTONS &ndash;&gt;
                    &lt;!&ndash; SIDEBAR MENU &ndash;&gt;
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active">
                                <a href="app_ticket.html">
                                    <i class="icon-home"></i> Ticket List </a>
                            </li>
                            <li>
                                <a href="app_ticket_staff.html">
                                    <i class="icon-settings"></i> Support Staff </a>
                            </li>
                            <li>
                                <a href="app_ticket_config.html">
                                    <i class="icon-info"></i> Configurations </a>
                            </li>
                        </ul>
                    </div>
                    &lt;!&ndash; END MENU &ndash;&gt;
                </div>
                &lt;!&ndash; END PORTLET MAIN &ndash;&gt;
                &lt;!&ndash; PORTLET MAIN &ndash;&gt;
                <div class="portlet light ">
                    &lt;!&ndash; STAT &ndash;&gt;
                    <div class="row list-separated profile-stat">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 37</div>
                            <div class="uppercase profile-stat-text"> New</div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 51</div>
                            <div class="uppercase profile-stat-text"> Processed</div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 61</div>
                            <div class="uppercase profile-stat-text"> Completed</div>
                        </div>
                    </div>
                    &lt;!&ndash; END STAT &ndash;&gt;
                    <div>
                        <h4 class="profile-desc-title">About Marcus Doe</h4>
                        <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-globe"></i>
                            <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-twitter"></i>
                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-facebook"></i>
                            <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                        </div>
                    </div>
                </div>
                &lt;!&ndash; END PORTLET MAIN &ndash;&gt;
            </div>
            -->
            <div class="app-ticket app-ticket-list">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Guest List</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th> SL.</th>
                                        <th> Email</th>
                                        <th> Phone</th>
                                        <th> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <a href="<?php echo e(route("chats.chat_room", ['guest_id' => $guest->id])); ?>"><?php echo e($guest->email); ?></a>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route("chats.chat_room", ['guest_id' => $guest->id])); ?>"><?php echo e($guest->Phone); ?></a>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="<?php echo e(route("chats.chat_room", ['guest_id' => $guest->id])); ?>">Visit Chatroom</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/chats/dashboard.blade.php ENDPATH**/ ?>