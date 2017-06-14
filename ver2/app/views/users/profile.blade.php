@extends('layouts.private')

@section('content')

            <!--TAB CONTENT-->
            <div class="content_tab_text">
                {{Form::open(array('url' => '/user/setting'))}}
                @include('layouts._messages')
                <p><strong class="notice_1 uppercase color_red mgb10">Thông tin cá nhân</strong></p>
                <label for="">Họ tên:</label>
                <p>
                    {{Form::text('fullname', Auth::user()->fullname, array('class'=>'input_3', 'placeholder'=>'Họ tên'))}}
                </p>
                <label for="">Ngày sinh:</label>
                <p>
                    {{Form::text('birthday', Auth::user()->birthday, array('class'=>'input_3 datepicker', 'placeholder'=>'dd-mm-yyyy'))}}
                </p>
                {{--<label>Email:</label>--}}
                {{--<p>--}}
                    {{--{{Form::text('email', Auth::user()->email, array('class'=>'input_3', 'placeholder'=>'Email'))}}--}}
                {{--</p>--}}
                <label for="">Số CMND:</label>
                <p>
                    {{Form::text('cmnd', Auth::user()->cmnd, array('class'=>'input_3', 'placeholder'=>'Số Chứng minh nhân dân'))}}
                </p>
                <label for="">Ngày cấp:</label>
                <p>
                    {{Form::text('cmnd_ngaycap', Auth::user()->cmnd_ngaycap, array('class'=>'input_3 datepicker', 'placeholder'=>'Ngày cấp CMND'))}}
                </p>
                <label for="">Nơi cấp:</label>
                <p>
                    {{Form::text('cmnd_noicap', Auth::user()->cmnd_noicap, array('class'=>'input_3', 'placeholder'=>'Nơi cấp CMND'))}}
                </p>
                <label>Tên hiển thị:</label>
                <p>
                    {{Form::text('displayname', Auth::user()->displayname, array('class'=>'input_3', 'placeholder'=>'Họ tên'))}}
                </p>

                <br />
                @if(!empty(Auth::user()->un_password))
                <p><strong class="notice_1 uppercase color_red mgb10 mgt20">Thay đổi mật khẩu</strong></p>
                <label for="old_pass">Mật khẩu cũ:</label>
                <p>
                    {{Form::password('old_pass', array('class'=>'input_3'))}}
                </p>
                <label for="password">Mật khẩu mới:</label>
                <p>
                    {{Form::password('password', array('class'=>'input_3'))}}
                </p>
                <label for="password_confirmation">Nhập lại mật khẩu mới:</label>
                <p>
                    {{Form::password('password_confirmation', array('class'=>'input_3'))}}
                </p>
                <br />
                @endif
                <p><strong class="notice_1 uppercase color_red mgb10 mgt20">Thông báo</strong></p>
                <p>{{Form::checkbox('chkNoti', 1, isset(Auth::user()->thong_bao['noti']) && Auth::user()->thong_bao['noti']==1)}}Nhận thông báo từ English360</p>
{{--                <p>{{Form::checkbox('chkSms', 1, isset(Auth::user()->thong_bao['sms']) && Auth::user()->thong_bao['sms']==1)}}Nhận SMS hàng ngày</p>--}}
                <p>{{Form::checkbox('chkEmail', 1, isset(Auth::user()->thong_bao['email']) && Auth::user()->thong_bao['email']==1)}}Nhận thông báo qua Email</p>
                <p><input type="submit" class="btn_x btn_blue btn_padding bold" value="Lưu thay đổi" /></p>
            {{Form::close()}}
            </div>

<script>
    $(function(){
        $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
    })
</script>
@endsection