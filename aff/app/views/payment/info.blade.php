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
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Ngân hàng: </strong>{{Common::getAllBank()[$myBank['id']]}}
                </li>
                <li class="list-group-item">
                    <strong>Chi nhánh: </strong>{{$myBank['branch']}}
                </li>
                <li class="list-group-item">
                    <strong>Tên tài khoản: </strong>{{$myBank['account_name']}}
                </li>
                <li class="list-group-item">
                    <strong>Số tài khoản: </strong>{{$myBank['account_number']}}
                </li>
            </ul>
            <a href="/payment/setting" class="btn btn-info">Thay đổi</a>
        </div>
    </div>
@endsection