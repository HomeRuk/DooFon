<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IoT WeatherNow</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" >
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.css" />
        <link rel="stylesheet" href="{{ asset('css/color.css') }}"  />
        {{-- <link rel="stylesheet" href="{{ elixir('css/app.css') }}" /> --}}
        <style>
            body {
                font-family: 'Athiti', sans-serif;
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>
        @yield('header')
    </head>
    <body id="app-layout">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        IoT WeatherNow
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/home') }}">หน้าหลัก</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">เข้าระบบ</a></li> 
                        @else
					<ul class="nav navbar-nav">
                        <li><a href="{{ url('/devices/insert') }}">Add Device</a></li>
                    </ul>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                ยินดีต้อนรับ {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <!--
                                <li><a href="{{ url('/profiles/'.Auth::user()->id.'/edit/') }}"><i class="fa fa-btn fa-user"></i>แก้ไขข้อมูลส่วนตัว</a></li>
                                -->
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>ออกจากระบบ</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.js"></script>
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

        @yield('footer')
    </body>
</html>
