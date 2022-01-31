            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?php echo e(route('dashboard')); ?>">
                            <img src="<?php echo e(asset('assets/layouts/layout/img/ed.png')); ?>" alt="logo" style="margin:5px;width:100px" class="logo-default" />
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->






























































































































































































































































































                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="<?php echo e(asset('assets/layouts/layout/img/avatar3_small.jpg')); ?>" />
                                    <span class="username username-hide-on-mobile"> <?php echo e(auth()->user()->name); ?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
<!--                                    <li>
                                        <a href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-calendar"></i> My Calendar </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-envelope-open"></i> My Inbox
                                            <span class="badge badge-danger"> 3 </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-rocket"></i> My Tasks
                                            <span class="badge badge-success"> 7 </span>
                                        </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-lock"></i> Lock Screen </a>
                                    </li>-->
                                    <li>
                                        <a href="<?php echo e(route('logout')); ?>">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
<?php /**PATH /var/www/bazar/resources/views/layouts/partials/navigation.blade.php ENDPATH**/ ?>