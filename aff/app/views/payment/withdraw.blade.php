@extends('layouts.main')

@section('content')
    <script src="{{ asset('/js/jquery.number.min.js') }}"></script>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Rút tiền
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-info-money"></i>  Số dư hiện tại: <strong>{{number_format(Auth::user()->account()->balance)}}đ</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            @include('layouts._messages')
            {{Form::open(array('url'=>'/payment/withdraw'))}}
            <label>Tài khoản nhận tiền:</label>
            <div class="form-group input-group">
                {{Form::text('bank',Auth::user()->myBank()['account_number'].' - '.Common::getAllBank()[Auth::user()->myBank()['id']], array('class'=>'form-control', 'disabled'))}}
                <span class="input-group-btn"><a class="btn btn-default" href="/payment/setting"><i class="fa fa-edit"></i></a></span>
            </div>
            <label>Số tiền:</label>
            <div class="form-group input-group">
                {{Form::text('amount', Input::get('amount'), array('class'=>'form-control', 'placeholder'=>'Số tiền nhỏ hơn '.number_format(Auth::user()->account()->balance), 'id'=>'amount'))}}
                <span class="input-group-addon">VNĐ</span>
            </div>
            <p id="note" style="color: red"></p>
            <div class="form-group">
                <label>Ghi chút</label>
                {{Form::textarea('description',Input::get('description'), array('class'=>'form-control', 'rows'=>5))}}
            </div>
            {{--<div class="form-group">--}}
                {{--<label>Số tài khoản</label>--}}
                {{--{{Form::text('account_number',$myBank['account_number'], array('class'=>'form-control'))}}--}}
            {{--</div>--}}
            {{Form::submit('Xác nhận', array('class'=>'btn btn-primary'))}}
            {{Form::close()}}
        </div>
    </div>
    <script>
{{--        var balance = {{intval(Auth::user()->account()->balance)}};--}}
        var balance = 100000;
        $(function(){
            $("#amount").keyup(function(){
                var amount = $("#amount").val();
                if(amount > balance)
                {
                    $("#amount").val(balance);
                }
                var amount = $("#amount").val();
                $("#note").html($.number(amount)+" trong tổng số "+ $.number(balance));
            });
        });

    </script>
@endsection