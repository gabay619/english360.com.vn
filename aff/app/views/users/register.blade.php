@extends('layouts.outform')

@section('content')
    <div class="container">
        <div class="row">
            <div class="user-form">
            {{Form::open(array('url'=>'/user/register', 'class'=>'form-horizontal', 'method'=>'post'))}}
            @include('layouts._messages')

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
                {{Form::submit('Đăng ký', array('class'=>'btn btn-primary btn-lg btn-block login-button  mgt10 mgb10'))}}
                <p class="text-center" style="margin-top: 10px">Hoặc đăng ký bằng</p>
                <div class="text-center">
                    <a href="/user/login?redirect=1" class="social-icon fb"><i class="fa fa-fw" aria-hidden="true"></i></a>
                    <a href="/gg-callback.html" class="social-icon gg"><i class="fa fa-fw" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="form-group">
                <div class="login-register text-center mgt20">
                    <p>Đã có tài khoản, vui lòng <a href="/user/login">Đăng nhập</a></p>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection