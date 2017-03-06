@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Thông tin thanh toán
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            {{Form::open(array('url'=>'/user/payment-setting'))}}
            <div class="form-group">
                <label>Chọn ngân hàng</label>
                {{Form::select('id',$allBank,$myBank['id'], array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                <label>Chi nhánh</label>
                {{Form::text('branch', $myBank['branch'], array('class'=>'form-control', 'placeholder'=>'Tên chi nhánh, Tỉnh (Thành phố)'))}}
            </div>
            <div class="form-group">
                <label>Tên tài khoản</label>
                {{Form::text('account_name',$myBank['account_name'], array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                <label>Số tài khoản</label>
                {{Form::text('account_number',$myBank['account_number'], array('class'=>'form-control'))}}
            </div>
            {{Form::submit('Cập nhật', array('class'=>'btn btn-primary'))}}
            {{Form::close()}}
        </div>
    </div>
@endsection