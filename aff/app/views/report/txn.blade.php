@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Lịch sử giao dịch
            </h1>
        </div>
    </div>
    @datepicker($start, $end, '/report/txn')
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Giá trị</th>
                        <th>Hoa hồng</th>
                        <th>Kênh</th>
                        <th>Thời gian</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allTxn as $aTxn)
                        <tr>
                            <td>{{$aTxn->ref() ? $aTxn->ref()->email : ''}}</td>
                            <td>{{number_format($aTxn->amount)}}</td>
                            <td>{{number_format($aTxn->discount)}}</td>
                            <td>{{Common::getPaymentMethod($aTxn->method)}}</td>
                            <td>{{date('d/m/Y H:i',$aTxn->datecreate)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                    {{$allTxn->appends(['start' => $start, 'end'=>$end])->links()}}
            </div>
        </div>

    </div>

@endsection