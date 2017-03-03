@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="text-center">
        <p>Mã xác thực (OTP) đã được gửi vào số điện thoại <strong>{{$msisdn}}</strong></p>
        <p>Vui lòng nhập vào ô bên dưới để xác nhận thanh toán.</p>
    </div>
    <div class="content_tab_text">
        <div class="list_bhdl block" style="padding: 0 20%">
            @include('layouts._messages')
            {{Form::open(array('url' => '/user/package-otp-confirm'))}}
            {{Form::hidden('txn_id',$txn->_id)}}
            <p>{{Form::text('otp', Input::get('otp'), array('class'=>'input_3', 'placeholder'=>'Mã xác thực (OTP)', 'required','value'=>Input::get('otp')))}}</p>
            <p>
                {{Form::submit('Thanh toán', array('class' => 'btn_x btn_blue btn_padding bold'))}}
            </p>
            {{Form::close()}}
        </div>
    </div>
@endsection