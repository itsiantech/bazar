<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'SD App')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
<div id="app">
    
    
    
    
    
    
    
    

    
    
    

    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    

    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
<style>
    /*<a href="https://www.freepik.com/free-photos-vectors/background">Background photo created by starline - www.freepik.com</a>*/
    body {
        background-color: #D7EAE3;
        background-image: url(<?php echo e(asset("assets/authimages/bg3.jpg")); ?>);
        background-position: center;
        background-repeat: no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-attachment: fixed;
    }
    .card {
        margin-top: 20%;
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: rgba(192, 192, 194,.3);
        background-clip: border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }
    .card-header:first-child {
        border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        background: rgb(192, 192, 194);
    }
    .form-control {
        display: block;
        width: 100%;
        height: calc(2.19rem + 2px);
        padding: .375rem .75rem;
        font-size: .9rem;
        line-height: 1.6;
        color: #495057;
        background-color: #fff0;
        background-clip: padding-box;
        border: 1px solid #504c4c;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
</style>
</body>
</html>
<?php /**PATH /var/www/bazar/resources/views/layouts/old-app.blade.php ENDPATH**/ ?>