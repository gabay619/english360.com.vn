@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="text-center">
        <p>Gói cước có giá <strong>{{number_format($selectPkg->price)}}đ</strong>, quý khách vui lòng nạp thẻ có mệnh giá ít nhất <strong>{{number_format($selectPkg->price)}}đ</strong></p>
        <p>Số tiền thừa sẽ được cộng vào <strong>Số dư</strong> để sử dụng về sau</p>
    </div>
    <div class="content_tab_text">
        <div class="list_bhdl block" style="padding: 0 20%">
            @include('layouts._messages')
            {{Form::open(array('url' => '/user/package-card'))}}
            {{Form::hidden('pkg',$selectPkg->_id)}}
            <p>{{Form::select('card_type', $listCardType, null, array('class'=>'input_3','required'))}}</p>
            <p>{{Form::text('pin', Input::get('pin'), array('class'=>'input_3', 'placeholder'=>'Mã thẻ', 'required','value'=>Input::get('pin')))}}</p>
            <p>{{Form::text('seri', Input::get('seri'), array('class'=>'input_3', 'placeholder'=>'Số Seri', 'required','value'=>Input::get('seri')))}}</p>
            <p>
                {{Form::submit('Nạp thẻ', array('class' => 'btn_x btn_blue btn_padding bold'))}}
            </p>
            {{Form::close()}}
        </div>
    </div>
@endsection