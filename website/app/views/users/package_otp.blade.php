@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="text-center">
        <p>Vui lòng nhập số điện thoại để nhận OTP xác thực thanh toán</p>
        <p>Số điện thoại dùng để thanh toán phải có tài khoản gốc lớn hơn {{number_format($selectPkg->price)}}đ</p>
    </div>
    <div class="content_tab_text">
        <div class="list_bhdl block" style="padding: 0 20%">
            @include('layouts._messages')
            {{Form::open(array('url' => '/user/package-otp'))}}
            {{Form::hidden('pkg',$selectPkg->_id)}}
{{--            <p>{{Form::select('card_type', $listCardType, null, array('class'=>'input_3','required'))}}</p>--}}
            <p>{{Form::text('msisdn', Input::get('msisdn'), array('class'=>'input_3', 'placeholder'=>'Số điện thoại (Viettel, Mobifone)', 'required','value'=>Input::get('msisdn')))}}</p>
            <p>
                {{Form::submit('Nhận mã xác thực (OTP)', array('class' => 'btn_x btn_blue btn_padding bold'))}}
            </p>
            {{Form::close()}}
        </div>
    </div>
@endsection