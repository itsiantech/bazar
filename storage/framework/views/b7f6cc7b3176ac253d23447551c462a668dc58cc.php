<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
<!-- <script src="<?php echo e(asset('js/app.js')); ?>" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php echo $__env->make('layouts.asset.common-css-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo e(asset('assets/layouts/layout/css/layout.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('assets/layouts/layout/css/themes/darkblue.min.css')); ?>" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="<?php echo e(asset('assets/layouts/layout/css/custom.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <!-- Styles -->
<!-- <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet"> -->
    <?php echo $__env->yieldPushContent('stylesheets'); ?>
</head>
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

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo e(asset('assets/global/plugins/jquery.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/js.cookie.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"
        type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/jquery.blockui.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo e(asset('assets/global/scripts/app.min.js')); ?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo e(asset('assets/layouts/layout/scripts/layout.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/layouts/layout/scripts/demo.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/layouts/global/scripts/quick-sidebar.min.js')); ?>" type="text/javascript"></script>

<script>



    $("#messageDiv").show().delay(2000).queue(function (n) {
        $(this).hide();
        n();
    });

    var loadFile = function (event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

</script>
<!-- END THEME LAYOUT SCRIPTS -->
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/bazar/resources/views/layouts/app.blade.php ENDPATH**/ ?>