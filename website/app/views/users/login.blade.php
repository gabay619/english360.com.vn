@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Đăng nhập</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block">
                        <h4 class="title_1">Đăng nhập</h4>
                        @include('layouts._messages')
                        {{Form::open(array('url' => '/user/login', 'style'=>'width: 500px'))}}
                            <p>{{Form::text('phone', Input::get('phone'), array('class'=>'input_3', 'placeholder'=>'Số điện thoại/Tên đăng nhập', 'autofocus', 'required','value'=>Input::get('phone')))}}</p>
                            <p>{{Form::password('password', array('class'=>'input_3', 'placeholder'=>'Mật khẩu', 'required'))}}</p>
                            <p><input type="checkbox" checked> Ghi nhớ đăng nhập</p>
                            <p>{{Form::submit('Đăng nhập', array('class' => 'btn_x btn_blue btn_padding bold'))}}</p>
                        {{Form::close()}}
                        <p><a style="text-decoration: underline" href="/user/forget-pass">Quên mật khẩu?</a> - <a style="text-decoration: underline" data-featherlight="#fl1" href="/user/register">Tạo tài khoản mới</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection