<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DooFon</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.css"/>

    <link rel="stylesheet" href="{{ asset('css/color.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"/>
    {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}"  /> --}}

    <style>
        body {
            font-family: 'Athiti', sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    @yield('header')
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <div class="col-md-10 col-md-offset-1">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="fa fa-cloud"></span> <b>DooFon</b>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/admin/map') }}"><i class="fa fa-map-marker"></i> แผนที่</a></li>
                    <li><a href="{{ url('/admin/devices/') }}"><i class="fa fa-mobile"></i> รายการอุปกรณ์IoT</a></li>
                    <li><a href="{{ url('/admin/model_predicts') }}"><i class="fa fa-database"></i> โมเดลพยากรณ์</a>
                    </li>
                    <li><a href="{{ url('/admin/report') }}"><i class="fa fa-cloud"></i> รายงานสภาพอากาศ</a></li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> ยินดีตอนรับ
                            @if(Auth::user()->status == 'Admin')
                                {{ Auth::user()->name }} (ผู้ดูแล)
                            @else
                                {{ Auth::user()->name }}
                            @endif
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/admin/register') }}"><i class="fa fa-plus-circle"></i> สร้างบัญชีผู้ใช้</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>ออกจากระบบ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

@yield('content')
<!-- JavaScripts -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

@yield('footer')
<!-- Include this after the sweet alert js file -->
@include('sweet::alert')
</body>
</html>
