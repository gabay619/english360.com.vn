@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="content_tab_text">
        <div class="list_bhdl block" style="padding: 0 20%">
            @include('layouts._messages')
            {{Form::open(array('url' => '/user/package-bank'))}}
            {{Form::hidden('pkg',$selectPkg->_id)}}
            <p>{{Form::number('amount', Input::get('amount'), array('class'=>'input_3', 'placeholder'=>'Số tiền cần nạp (ít nhất 10.000đ)', 'required','id'=>'numAmount'))}}</p>
            <p>
                {{Form::submit('Thanh toán', array('class' => 'btn_x btn_blue btn_padding bold'))}}
            </p>
            {{Form::close()}}
        </div>
    </div>
@endsection