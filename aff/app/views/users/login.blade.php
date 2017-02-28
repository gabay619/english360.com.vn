@extends('layouts.outform')

@section('content')
        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Đăng nhập</h1>
                <hr />
            </div>
        </div>
        <div class="main-login main-center">
            {{Form::open(array('url'=>'/user/login', 'class'=>'form-horizontal', 'method'=>'post'))}}

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

            <div class="form-group ">
                {{Form::submit('Đăng nhập', array('class'=>'btn btn-primary btn-lg btn-block login-button'))}}
                <p class="text-center">hoặc</p>
                <a href="{{$fb_login}}" class="btn btn-primary btn-lg btn-block" style="background-color: rgb(64,93,155) !important;">Đăng nhập bằng Facebook</a>
            </div>
            <div class="login-register">
                <a href="/user/register">Đăng ký</a> -
                <a href="#">Quên mật khẩu</a>
            </div>
            {{Form::close()}}
        </div>
@endsection