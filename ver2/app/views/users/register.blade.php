@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Đăng ký</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block">
                        <h4 class="title_1">Đăng ký</h4>
                        <p class="text-danger" id="flsMss"></p>
                        {{Form::open(array('url' => '/user/register', 'style'=>'width: 500px'))}}
                        <p>{{Form::text('email', Input::get('email'), array('class'=>'input_3', 'placeholder'=>'Email','id'=>'txtRegEmail','autofocus', 'required'))}}</p>
                        <p>{{Form::password('password', array('class'=>'input_3', 'placeholder'=>'Mật khẩu','id'=>'txtRegPassword'))}}</p>
                        <p>{{Form::password('password_confirmation', array('class'=>'input_3', 'placeholder'=>'Xác nhận mật khẩu','id'=>'txtRegPasswordConfirmation'))}}</p>
                        <p>
                            <button type="submit" class="btn_x btn_blue btn_padding bold">Đăng ký</button>

                            {{--<a href="/user/login?redirect=1" class="btn_x btn_padding bold btn_blue" style="background-color: rgb(64,93,155) !important;">Đăng ký bằng Facebook</a>--}}
                        </p>
                        <p>Hoặc đăng ký bằng</p>
                        <p>
                            <a href="/user/login?redirect=1" class="social-icon fb"></a>
                            <a href="/gg-callback.html" class="social-icon gg"></a>
                        </p>
{{--                        <p>{{Form::submit('Đăng ký', array('class' => 'btn_x btn_blue btn_padding bold'))}}</p>--}}
                        {{Form::close()}}
                        <p>Bạn đã có tài khoản? <a style="text-decoration: underline" href="/user/login">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<script>--}}
        {{--function register() {--}}
            {{--email = $('#txtRegEmail').val();--}}
            {{--password = $('#txtRegPassword').val();--}}
            {{--password_confirmation = $('#txtRegPasswordConfirmation').val();--}}
            {{--$.post('/user/register', {--}}
                {{--email: email, password:password, password_confirmation:password_confirmation,_token : '{{ csrf_token() }}', rd_login:1--}}
            {{--}, function (re) {--}}
                {{--if(re.success){--}}
                    {{--window.location.href= '/user/login?username='+username;--}}
                {{--}else{--}}
                    {{--$('#flsMss').html('<b>'+re.message+'</br>');--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}
    {{--</script>--}}
@endsection