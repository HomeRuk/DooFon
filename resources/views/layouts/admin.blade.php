<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin DooFon</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" >
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.css" />
        <link rel="stylesheet" href="{{ asset('css/color.css') }}"  />
        {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}"  /> --}}

        <style>
            body {
                font-family: 'Athiti', sans-serif;
            }  
            .fa-btn {
                margin-right: 6px;
            }
            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {height: 767px}

            /* Set gray background color and 100% height */
            .sidenav {
                background-color: #f1f1f1;
                height: 100%;
            }

            /* On small screens, set height to 'auto' for the grid */
            @media screen and (max-width: 767px) {
                .row.content {height: auto;} 
            }
        </style>

        @yield('header')
    </head>
    <body id="app-layout">
        <nav class="navbar navbar-inverse visible-xs">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="#">DooFon</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Dashboard</a></li>
                        <li><a href="#">Age</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row content">
                <div class="col-md-2 sidenav hidden-xs">
                    <h1 class="page-header">Admin</h1>
                    <ul class="nav nav-stacked ">
                        <li class="active"><a href="#section1">Dashboard</a></li>
                        <li><a href="#section2">Add Device</a></li>
                    </ul>
                </div>
            
        <div class="col-md-10">
            @yield('content')
        </div>
        </div>
        </div>
        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/sweetalert2/4.0.7/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.js"></script>
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    @yield('footer')
</body>
</html>
