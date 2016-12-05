@extends('layouts.login')

@section('content')
<header>
    <center>
        @if (count($errors) > 0)
        <div class="alert" style="background-color:#e6e600;font-size:larger;text-shadow: 1px 1px 1px #000000;">
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
        </div>
        @endif
    </center>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3">
                <center><h1 class="font-header color-header">DooFon</h1></center>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <center><img src="{{ asset('images/login.png') }}" class="img-circle img-responsive"/></center>
                        <center style="color:#808080;"><h1>Sign in</h1></center>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <!--
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                -->
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <input style="height:60px;font-size:20px;" id="email" type="email" class="form-control input-lg" name="email"  placeholder="Email Address" value="{{ old('email') }}" required autofocus >

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <!--
                                <label for="password" class="col-md-4 control-label">Password</label>
                                -->
                                <div class="col-md-12">    
                                    <div class="col-md-12">
                                        <input style="height:60px;font-size:20px;" id="password" type="password" class="form-control input-lg" name="password" placeholder="Password" required>

                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" name="remember"> Remember Me
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                            -->
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-success btn-block ">
                                            <h4 style="font-size:22px;"><i class="fa fa-btn fa-sign-in"></i>Sign in</h4>
                                        </button>
                                        <a class="btn btn-block" href="{{ url('/password/reset') }}"><h4>Forgot Your Password?</h4></a>
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
