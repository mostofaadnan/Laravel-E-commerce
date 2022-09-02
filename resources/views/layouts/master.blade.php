<?php $company = \App\Models\Company::where('id', 1)->first(); ?>
<!DOCTYPE html>
<!-- <html lang="en"> -->
<html lang="{{app()->getLocale()}}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url"           content="{{ route('home') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Medical & Health Care">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/images/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/images/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/images/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/images/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/images/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/images/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/images/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/images/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/images/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/images/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/images/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <title>{{ $company->name }} </title>

    <!-- <script src="https://cdn.tiny.cloud/1/63vzfouwg6wz5nugyo702or5t71lr7sp7c6l9n2k78qlk31o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
    @include('partials.styles') 
    @include('partials.scripts')
    <script>
    /*  
        Pusher.logToConsole = true;

        var pusher = new Pusher('3f84823479d480bf0316', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('Deyspharma-production');
        channel.bind('RealTimeMessage', function(data) {
            alert(JSON.stringify(data));
            console.log(JSON.stringify(data))
            addMessage(data);

        });



        function addMessage(data) {
          console.log(data)
            var listItem = $("<li class='list-group-item'></li>");
            listItem.html(data);
            $('#messagess').append(listItem);
        }

       */ 
    </script>
</head>

<body class="nav-md">
    <div class="container-box body">
        <div class="main_container">
            <div class="col-md-3 left_col my-custom-scrollbar sidebar-left">
                <div class="left_col">
                    <div class="navbar nav_title" style="border: 0;">
                        <a class="navbar-brand" href="{{route('home')}}" target="_blank"><span class="header-title-A"><b>{{ $company->name }}</b></a>
                        <!--   <a class="navbar-brand" href="{{route('home')}}"><img src="{{ asset('images/logo/logo.png') }}" width="170" height="50" alt=""></a> -->
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{asset('storage/app/public/user/'.Auth::user()->image)}}" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>@lang('home.welcome'),</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    @include('partials.sidebar')
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    @include('partials.footerbutton')
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            @include('partials.TopNavigation')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" style="background-color:#fff;">

                <div class="clearfix"></div>
                <!--   @include('partials.shortcutMenu') -->
                @yield('content')

            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                @include('partials.footer')
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <script src="{{asset('assets/js/custom/custom.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
</body>

</html>