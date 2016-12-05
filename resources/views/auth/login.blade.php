@extends('layouts.login')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center><h1 class="font-header color-header">DooFon</h1></center>
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading"><center><img src="{{ asset('images/login.png') }}" class="img-circle img-responsive"/></center></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <!--
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                -->
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control input-lg" name="email"  placeholder="Email address" value="{{ old('email') }}" required autofocus >

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <!--
                                <label for="password" class="col-md-4 control-label">Password</label>
                                -->

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control input-lg" name="password" placeholder="Password" required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-lg btn-success btn-block ">
                                        <i class="fa fa-btn fa-sign-in"></i> Sign in
                                    </button>

                                    <a class="btn btn-block" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
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
