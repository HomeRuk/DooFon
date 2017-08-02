@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading">
                        <h2>รายละเอียดบัญชีผู้ใช้ <u>{{ $user->username }}</u></h2>
                    </div>
                    <div class="panel-body">

                        <div class="col-xs-12">
                            @if($user->profile->image && File::exists(public_path().'/images_resize/256/'.$user->profile->image))
                                <img class="img-responsive img-circle img-thumbnail center-block"
                                     src="{{ asset('/images_resize/256/'.$user->profile->image) }}" height="256px" width="256px"/>
                            @else
                                <img class="img-responsive img-circle img-thumbnail center-block"
                                     src="{{ asset('/images/nopic.png') }}" width="256px"/>
                            @endif
                            <hr/>
                        </div>

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
                                {{ Form::text('tel', isset($user->profile->tel) ? $user->profile->tel : '-' ,['class' => 'form-control','disabled']) }}
                            </div>
                            <hr/>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-group form-group-lg">
                                <a class="btn btn-lg btn-warning btn-block edit-UserProfile" href="#">
                                    <span class="fa fa-pencil"></span> แก้ไข
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group form-group-lg">
                                <form method="POST" action="{{ url('/admin/AccountManagement/'.$user->id) }}">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn btn-lg btn-danger btn-block" href="#">
                                        <span class="fa fa-trash"></span> ลบ
                                    </button>
                                </form>
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
                    <h3 class="modal-title">แก้ไขข้อมูลส่วนตัวของ {{ $user->username }}</h3>
                </div>
                <div class="modal-body">
                    {!! Form::model($user , array('url' => '/admin/AccountManagement/'.$user->id,'files'=> true,'method' => 'PATCH','id' => 'update')) !!}
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
                            {{ Form::text('tel', isset($user->profile->tel) ? $user->profile->tel : null ,['class' => 'form-control','pattern'=>'[0-9]{10}','title'=>'กรุณากรอกตัวเลข 10 หลัก']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-lg">
                            {{ Form::label('image', 'รูปภาพ')  }}
                            {{ Form::file('image',null,['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if(isset($user->profile->image) && File::exists(public_path().'/images_resize/50/'.$user->profile->image))
                            <a href="{{ asset('images/'.$user->profile->image) }}" data-lity>
                                <img src="{{ asset('images_resize/50/'.$user->profile->image) }}" width="50"
                                     height="50">
                            </a>
                        @endif
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
