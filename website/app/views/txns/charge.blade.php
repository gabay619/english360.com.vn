@extends('layouts.private')
@section('content')
    <!--TAB CONTENT-->
    <div class="content_tab_text">
        <p><strong class="notice_1 uppercase color_red mgb10">Bạn hiện có: {{Auth::user()->getBalance()}} {{Constant::CASH_NAME}}</strong></p>
        <div style="clear: both"></div>
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#card" data-toggle="tab">Thẻ cào</a></li>
                <li><a href="#bank" data-toggle="tab">Banking</a></li>
                <li><a href="#method3" data-toggle="tab">Method 3</a></li>
                <li><a href="#method4" data-toggle="tab">Method 4</a></li>
            </ul>
            <div class="tab-content" style="padding: 20px; border-top: none">
                <div id="card" class="tab-pane fade in active">
                    @include('layouts._messages')
                    {{Form::open(array('url' => '/txn/charge-card'))}}
                    <p>{{Form::select('card_type', $listCardType, null, array('class'=>'input_3'))}}</p>
                    <p>{{Form::text('pin', Input::get('pin'), array('class'=>'input_3', 'placeholder'=>'Mã thẻ', 'required','value'=>Input::get('pin')))}}</p>
                    <p>{{Form::text('seri', Input::get('seri'), array('class'=>'input_3', 'placeholder'=>'Số Seri', 'required','value'=>Input::get('seri')))}}</p>
                    <p>
                        {{Form::submit('Nạp thẻ', array('class' => 'btn_x btn_blue btn_padding bold'))}}
                    </p>
                    {{Form::close()}}
                </div>
                <div id="bank" class="tab-pane fade">
                    <h3>Nạp tiền qua Ngân hàng</h3>
                    <p>Đang xây dựng.</p>
                </div>
                <div id="method3" class="tab-pane fade">
                    <h3>Method 3</h3>
                    <p>Đang xây dựng.</p>
                </div>
                <div id="method4" class="tab-pane fade">
                    <h3>Method 4</h3>
                    <p>Đang xây dựng.</p>
                </div>
            </div>
        </div>

    </div>
@endsection