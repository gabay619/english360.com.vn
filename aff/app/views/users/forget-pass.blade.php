@extends('layouts.outform')

@section('content')
    <div class="container">
        <div class="row">
            <div class="user-form">
                @if(!Session::has('success'))
                    <p>Vui lòng nhập email của bạn. Hệ thống sẽ gửi mật khẩu về email của bạn trong giây lát.</p>
                @endif
                {{Form::open(array('url'=>'/user/forget-pass', 'class'=>'form-horizontal col-sm-12', 'method'=>'post'))}}
                @include('layouts._messages')
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
        </div>
    </div>
@endsection
