<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DooFon</title>
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
        </style>
        @yield('header')
    </head>
    <body id="app-layout" class="bg-login">
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
