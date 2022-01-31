<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
@include('layouts.asset.common-css-header')
<!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="{{ asset('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    @stack('stylesheets')
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
<div class="page-wrapper">
@include('layouts.partials.navigation')
<!-- BEGIN CONTAINER -->
    <div class="page-container">
    @include('layouts.partials.sidebar')
    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">Go to Dashboard</a>
                                                                <i class="fa fa-circle"></i>
                        </li>
                        {{-- <li>
                            <a href="http://bangoshop.com/" target="_blank">Visit Website</a>
                        </li> --}}
                    </ul>
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                @yield('content')
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
<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>

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
@stack('scripts')
</body>
</html>
