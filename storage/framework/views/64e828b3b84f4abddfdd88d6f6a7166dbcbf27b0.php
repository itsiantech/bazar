<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<!-- Fonts -->

<!-- END THEME LAYOUT STYLES -->
<!-- Styles -->
<!-- <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet"> -->
<?php echo $__env->yieldPushContent('stylesheets'); ?>

<head>
    <meta charset="utf-8" />
    <title>BangoShop | Invoice</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo e(asset('assets/global/css/components-md.min.css')); ?>" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo e(asset('assets/global/css/plugins-md.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo e(asset('assets/pages/css/invoice.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo e(asset('assets/layouts/layout/css/layout.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/layouts/layout/css/themes/darkblue.min.css')); ?>" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo e(asset('assets/layouts/layout/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <style>
        @media  print { @page  { margin: 0; }
            body { margin: 1.6cm; } }
    </style>
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
<div class="page-wrapper">
<?php echo $__env->make('layouts.partials.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- BEGIN CONTAINER -->
    <div class="page-container">
    <?php echo $__env->make('layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="<?php echo e(route('dashboard')); ?>">Go to Dashboard</a>
                                                                <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            

                        </li>
                        
                        
                        
                    </ul>
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2021-22 &copy; BangoShop</div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>



<script src="<?php echo e(asset('assets/global/plugins/respond.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/plugins/excanvas.min.js')); ?>"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo e(asset('assets/global/plugins/jquery.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/js.cookie.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/jquery.blockui.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo e(asset('assets/global/scripts/app.min.js')); ?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo e(asset('assets/layouts/layout/scripts/layout.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/layouts/layout/scripts/demo.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/layouts/global/scripts/quick-sidebar.min.js')); ?>" type="text/javascript"></script>
<script>



</script>
<!-- END THEME LAYOUT SCRIPTS -->
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/bazar/resources/views/layouts/invoice.blade.php ENDPATH**/ ?>