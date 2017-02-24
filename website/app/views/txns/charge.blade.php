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
                <li><a href="#sms" data-toggle="tab">SMS PLUS</a></li>
                <li><a href="#otp" data-toggle="tab">API OTP</a></li>
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
                    <p class="text-danger" id="ajaxBankMss"></p>
                    @include('layouts._messages')
                    {{Form::open(array('url' => '#'))}}
                    <p>{{Form::number('amount', Input::get('amount'), array('class'=>'input_3', 'placeholder'=>'Số tiền cần nạp (ít nhất 10.000đ)', 'required','id'=>'numAmount'))}}</p>
                    <p>
                        <button class="btn_x btn_blue btn_padding bold" onclick="chargeBank()" type="button">
                            Thanh toán
                        </button>
                    </p>
                    {{Form::close()}}
                </div>
                <div id="sms" class="tab-pane fade">
                    <h3>SMS PLUS</h3>
                    <p>Đang xây dựng.</p>
                </div>
                <div id="otp" class="tab-pane fade">
                    <h3>API OTP</h3>
                    <p>Đang xây dựng.</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function chargeBank() {
            amount = $('#numAmount').val();
            $.post('/txn/charge-bank', {
                amount:amount, _token: '{{csrf_token()}}'
            }, function (re) {
                if(re.success){
                    window.location.href = re.payUrl;
                }else{
                    $('#ajaxBankMss').html(re.message);
                }
            })
        }
    </script>
@endsection