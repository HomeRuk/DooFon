@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <span class="fa fa-users fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายการบัญชีผู้ใช้</span>
                    </div>
                    <div class="col-md-2">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <br>
                            <div class="form-group">
                                <a href="#" class="btn btn-blue add-User">
                                    <span class="fa fa-user-plus"></span> สร้างบัญชีผู้ใช้
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <hr/>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-xs btn-primary"><span class="fa fa-user"></span></button>
                            : <b>ผู้ใช้ทั่วไป</b>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-xs btn-success"><span class="fa fa-user-secret"></span></button>
                            : <b>ผู้ดูแล</b>
                        </div>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/admin/AccountManagement','role','name' ])!!}
                        <div class="input-group custom-search-form">
                            <input type="search" name="name" class="form-control" placeholder="ค้นหา name">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default-sm">
                                <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <br/>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($users->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-0">
                                @foreach ($users as $user)
                                    <div class="box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-1">
                                                    @if($user->profile->image && File::exists(public_path().'/images_resize/128/'.$user->profile->image))
                                                        <a href="{{ asset('images/'.$user->profile->image) }}" data-lity>
                                                            <img class="img-responsive img-circle img-thumbnail center-block" src="{{ asset('/images_resize/128/'.$user->profile->image) }}" height="128px" width="128px"/>
                                                        </a>
                                                    @else
                                                        <img class="img-responsive img-circle img-thumbnail center-block" src="{{ asset('/images/nopic.png') }}" height="128px" width="128px"/>
                                                    @endif
                                                </div>
                                                <div class="col-md-7">
                                                    <h4>{{ $user->name }}
                                                        <small> อัพเดทล่าสุด
                                                            : {{ $user->updated_at->diffForHumans(Carbon\Carbon::now()) }}
                                                            @if($user->id === $userIdNew)
                                                                <img class="img-responsive img-circle" width="32px"
                                                                     style="display: inline;"
                                                                     src="{{ asset('/images/new.svg') }}"/>
                                                            @endif
                                                        </small>
                                                    </h4>
                                                    <div class="form-group">
                                                        <div style="width: 120px;">
                                                            @if($user->status === 'Admin')
                                                                <button class="btn btn-sm btn-success btn-block">
                                                                    <span class="fa fa-user-secret"></span> ผู้ดูแล
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary btn-block">
                                                                    <span class="fa fa-user"></span> ผู้ใช้ทั่วไป
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <a class="btn btn-success btn-block sent-msg"
                                                           href="#">
                                                            <span class="fa fa-send"></span> ส่งข้อความ
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <a class="btn btn-blue btn-block"
                                                           href="{{  url('/admin/AccountManagement/'.$user->id)}}">
                                                            <span class="fa fa-eye"></span> ดูรายละเอียด
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="lineblue">
                                @endforeach
                            </div>
                            {!! $users->render() !!}
                        </div>
                    </div>
                @else
                    <div class="title">ไม่พบข้อมูล
                        <h1>บัญชีผู้ใช้</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal form to Sent Massage Notification -->
    <div id="sentMsg" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">ส่งข้อความ Notification</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ url('/admin/AccountManagement') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="form-group form-group-lg">
                                    <label>ข้อความ</label>
                                    <input class="form-control" type="text" name="massage" id="massage" value=""
                                           placeholder="ตย. โปรโมชั่น"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="form-group form-group-lg">
                                    <button class="btn btn-lg btn-success btn-block" type="submit"> ส่ง</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{--End Form--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to add a user user -->
    <div id="addUser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">สร้างบัญชีผู้ใช้</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ url('/admin/AccountManagement') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">สถานะ</label>

                            <div class="col-md-6">
                                <input id="status" type="radio" name="status" value="User" checked>
                                <h4 style="display: inline">ผู้ใช้งานทั้วไป (User)</h4>
                                <br/><br/>
                                <input id="status" type="radio" name="status" value="Admin">
                                <h4 style="display: inline">ผู้ดูแล (Admin)</h4>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">ชื่อบัญชีผู้ใช้</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username"
                                       placeholder="Username"
                                       value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">ชื่อที่แสดง</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Display Name"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">ชื่อที่อยู่อีเมล์</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       placeholder="E-Mail Address"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">รหัสผ่าน</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"
                                       placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">ยืนยันรหัสผ่าน</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" placeholder="Confirm Password" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    <i class="fa fa-btn fa-user-plus"></i> สร้างบัญชีผู้ใช้
                                </button>
                            </div>
                        </div>
                    </form>
                    {{--End Form--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{asset('/js/jQueryAccountManagement.js')}}"></script>
@endsection
