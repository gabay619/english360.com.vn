@extends('layouts.outform')

@section('content')

        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Đăng ký</h1>
                <hr />
            </div>
        </div>
        <div class="main-login main-center">
            {{Form::open(array('url'=>'/user/login', 'class'=>'form-horizontal', 'method'=>'post'))}}
            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">Họ và tên</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        {{Form::text('fullname', Input::get('fullname'), array('id'=>'fullname','class'=>'form-control', 'placeholder'=>'Nhập họ tên', 'autofocus'))}}
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">Email</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                        {{Form::text('email', Input::get('email'), array('id'=>'email','class'=>'form-control', 'placeholder'=>'Nhập Email'))}}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">Số điện thoại</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-mobile fa" aria-hidden="true"></i></span>
                        {{Form::text('phone', Input::get('phone'), array('id'=>'phone','class'=>'form-control', 'placeholder'=>'Nhập SĐT'))}}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="cols-sm-2 control-label">Mật khẩu</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        {{Form::password('password', array('class'=>'form-control','id'=>'password', 'placeholder'=>'Nhập mật khẩu'))}}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="cols-sm-2 control-label">Xác nhận mật khẩu</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        {{Form::password('password_confirmation', array('class'=>'form-control','id'=>'password', 'placeholder'=>'Xác nhận mật khẩu'))}}
                    </div>
                </div>
            </div>

            <div class="form-group ">
                {{Form::submit('Đăng ký', array('class'=>'btn btn-primary btn-lg btn-block login-button'))}}
                <p class="text-center">hoặc</p>
                <a href="/user/login?redirect=1" class="btn btn-primary btn-lg btn-block" style="background-color: rgb(64,93,155) !important;">Đăng ký bằng Facebook</a>
            </div>
            <div class="login-register">
                <a href="/user/login">Đăng nhập</a>
            </div>
            {{Form::close()}}
        </div>
@endsection