@extends('layouts.outform')

@section('content')

    <div class="panel-heading">
        <div class="panel-title text-center">
            <h1 class="title">Quên mật khẩu</h1>
            <hr />
        </div>
    </div>
    <div class="main-login main-center">
        @if(!Session::has('success'))
            <p>Vui lòng nhập email của bạn. Hệ thống sẽ gửi mật khẩu về email của bạn trong giây lát.</p>
        @endif
        @include('layouts._messages')
        {{Form::open(array('url'=>'/user/forget-pass', 'class'=>'form-horizontal', 'method'=>'post'))}}
        <div class="form-group">
            <div class="cols-sm-10">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                    {{Form::text('email', Input::get('email'), array('id'=>'email','class'=>'form-control', 'placeholder'=>'Nhập email', 'autofocus', 'required'))}}
                </div>
            </div>
        </div>

        <div class="form-group ">
            {{Form::submit('Nhận mật khẩu', array('class'=>'btn btn-primary btn-lg btn-block login-button'))}}
        </div>
        {{Form::close()}}
    </div>
@endsection
