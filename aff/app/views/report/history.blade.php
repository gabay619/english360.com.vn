@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Lịch sử sử dụng <small>{{$user->email}}</small>
            </h1>
        </div>
    </div>
    @datepicker($start, $end)
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Hành động</th>
                        <th>URL</th>
                        <th>Kênh</th>
                        <th>Thời gian</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allLog as $aLog)
                        <tr>
                            <td>{{HistoryLog::getArr()[$aLog->action]}}</td>
                            <td><a href="{{$aLog->url}}" target="_blank">LINK</a></td>
                            <td>{{$aLog->chanel}}</td>
                            <td>{{date('d/m/Y H:i',$aLog->datecreate)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{$allLog->appends(['start' => $start, 'end'=>$end])->links()}}
            </div>
        </div>

    </div>

@endsection