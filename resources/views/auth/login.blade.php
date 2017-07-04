@extends('layouts.login')

@section('content')
    <header>
        <div style="text-align: center;">
            @if (count($errors) > 0)
                <div class="alert" style="background-color:#e6e600;font-size:larger;text-shadow: 1px 1px 1px #000000;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 col-md-offset-4">
                    <!-- LOGO LOGIN -->
                    <div align="center" style="margin-top: 20%;">
                        <!-- Branding Image -->
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/images/logo.png') }}" class="img-responsive" style="max-width: 130px"/>
                        </a>
                    </div>
                    <div style="text-align: center;">
                        <h1 class="color-header">
                            <b>DooFon</b>
                        </h1>
                        <h3 class="color-header" style="margin-bottom: 10%">Local rain forecast system</h3>
                    </div>
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <div style="color:#808080; text-align: center;"><h2>ลงชื่อเข้าใช้</h2></div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <!-- INPUT USERNAME -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            {!! Form::label('username', 'ชื่อผู้ใช้') !!}
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                                            </span>
                                                <input id="username" type="text"
                                                       class="form-control input-lg" name="username"
                                                       placeholder="Username"
                                                       value="{{ old('username') }}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- INPUT PASSWORD -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            {!! Form::label('password', 'รหัสผ่าน') !!}
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-lock" aria-hidden="true"></i>
                                            </span>
                                                <input id="password" type="password" class="form-control input-lg"
                                                       name="password" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <!-- BUTTON SUBMIT Sign in-->
                                            <button type="submit" class="btn btn-lg btn-success btn-block ">
                                                <i class="fa fa-btn fa-sign-in"></i>ลงชื่อเข้าใช้
                                            </button>
                                            <!-- Link Forgot Password -->
                                            <a class="btn btn-block" href="{{ url('/password/reset') }}">ลืมรหัสผ่านหรือไม่?</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
