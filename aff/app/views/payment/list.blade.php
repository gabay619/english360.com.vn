@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Lịch sử thanh toán
            </h1>
        </div>
    </div>
    @datepicker($start, $end, '/payment/list')
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Mã giao dịch</th>
                        <th>Số tiền</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Tài khoản</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allTxn as $aTxn)
                        <?php
                        switch ($aTxn->status){
                            case Constant::WITHDRAW_STATUS_COMPLETE:
                                $class = 'text-success';
                                break;
                            case Constant::WITHDRAW_STATUS_CANCEL:
                                $class = 'text-danger';
                                break;
                            default:
                                $class = 'text-info';
                                break;
                        }
                        ?>
                        <tr>
                            <td>{{$aTxn->_id}}</td>
                            <td>{{number_format($aTxn->amount)}}</td>
                            <td>{{date('d/m/Y H:i',$aTxn->datecreate)}}</td>
                            <td><b class="{{$class}}">{{Common::getWithdrawStatus($aTxn->status)}}</b></td>
                            <td>{{Common::getAllBank()[$aTxn->bank['id']]}} - {{Common::maskPhone($aTxn->bank['account_number'])}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{--                {{$aTxn->appends(['start' => $start, 'end'=>$end])->links()}}--}}
            </div>
        </div>

    </div>

@endsection