@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Quên mật khẩu</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block">
                        <h4 class="title_1">Quên mật khẩu</h4>
                        @include('layouts._messages')
                        @if(!Session::has('success'))
                        <p>Vui lòng nhập email của bạn. Hệ thống sẽ gửi mật khẩu về email của bạn trong giây lát.</p>
                        @endif
                        {{Form::open(array('url' => '/user/forget-pass', 'style'=>'width: 500px'))}}
                        <p>{{Form::text('email', Input::get('email'), array('class'=>'input_3', 'placeholder'=>'Email', 'autofocus', 'required'))}}</p>
                        <p>{{Form::submit('Nhận mật khẩu', array('class' => 'btn_x btn_blue btn_padding bold'))}}</p>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection