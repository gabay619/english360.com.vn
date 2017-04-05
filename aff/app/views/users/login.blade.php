@extends('layouts.outform')

@section('content')
    <div class="container">
        <div class="row">
            <div class="user-form">
            {{Form::open(array('url'=>'/user/login', 'class'=>'form-horizontal col-sm-12', 'method'=>'post'))}}
            @include('layouts._messages')
            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">Email</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                        {{Form::text('email', Input::get('email'), array('id'=>'email','class'=>'form-control', 'placeholder'=>'Nhập Email', 'autofocus'))}}
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
                {{Form::submit('Đăng nhập', array('class'=>'btn btn-primary btn-lg btn-block login-button mgt10 mgb10'))}}
                <p class="text-center" style="margin-top: 10px">Hoặc đăng nhập bằng</p>
                <div class="text-center">
                    <a href="{{$fb_login}}" class="social-icon fb"><i class="fa fa-fw" aria-hidden="true"></i></a>
                    <a href="/gg-callback.html" class="social-icon gg"><i class="fa fa-fw" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="login-register text-center mgt20">
                <a href="/user/register">Đăng ký</a> -
                <a href="/user/forget-pass">Quên mật khẩu</a>
            </div>
            {{Form::close()}}
        </div>
    </div>
    </div>
@endsection