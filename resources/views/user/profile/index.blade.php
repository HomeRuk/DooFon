@extends('layouts.user.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading">
                        <h2>แก้ไขข้อมูลส่วนตัวของ <u>{{ $user->name }}</u></h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="form-group form-group-lg">
                                {{ Form::label('username', 'ชื่อบัญชีผู้ใช้')  }}
                                {{ Form::text('username',$user->username,['class' => 'form-control','disabled']) }}
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group form-group-lg">
                                {{ Form::label('name', 'ชื่อ-สกุล')  }}
                                {{ Form::text('name',$user->name,['class' => 'form-control','disabled']) }}
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group form-group-lg">
                                {{ Form::label('email', 'อีเมล')  }}
                                {{ Form::text('email',$user->email,['class' => 'form-control','disabled']) }}
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group form-group-lg">
                                {{ Form::label('tel', 'โทรศัพท์')  }}
                                {{ Form::text('tel',isset($user->profile->tel) ? $user->profile->tel : null ,['class' => 'form-control','disabled']) }}
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group form-group-lg">
                                <a class="btn btn-lg btn-blue btn-block edit-UserProfile" href="#">
                                    <span class="fa fa-pencil"></span> แก้ไข
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to update a user profile -->
    <div id="editUserProfile" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">แก้ไขข้อมูลส่วนตัวของ {{ $user->name }}</h3>
                </div>
                <div class="modal-body">
                    {!! Form::model($user , array('url' => '/user/profile','method' => 'PUT','id' => 'update')) !!}
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::label('username', 'ชื่อบัญชีผู้ใช้')  }}
                            {{ Form::text('username',null,['class' => 'form-control','disabled']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::label('name', 'ชื่อ-สกุล')  }}
                            {{ Form::text('name',null,['class' => 'form-control','required']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::label('email', 'อีเมล')  }}
                            {{ Form::email('email',null,['class' => 'form-control','required']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::label('tel', 'โทรศัพท์')  }}
                            {{ Form::text('tel',isset($user->profile->tel) ? $user->profile->tel : null ,['class' => 'form-control','pattern'=>'[0-9]{10}','title'=>'กรุณากรอกตัวเลข 10 หลัก']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="form-group form-group-lg">
                            {{ Form::submit('ปรับปรุง',['class' => 'btn btn-lg btn-primary btn-block','id' => 'update']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{asset('/js/jQueryUserProfile.js')}}"></script>
@endsection
