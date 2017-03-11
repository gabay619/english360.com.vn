@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Báo cáo user
            </h1>
        </div>
    </div>
    @datepicker($start, $end, '/report/user')
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Thời gian</th>
                        <th>Nguồn</th>
                        <th>Thời hạn khóa học</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allUser as $user)
                        <tr>
                            <td>{{$user['email']}}</td>
                            <td>{{date('d/m/Y H:i',$user['aff']['datecreate'])}}</td>
                            <td>{{isset($user['aff']['sub_id']) ? $user['aff']['sub_id'] : ''}}</td>
                            <td>{{$user->getPackageTime() ? date('d/m/Y',$user->getPackageTime()) : 'Chưa ĐK'}}</td>
                            <td><a class="btn btn-primary btm-sm" href="/report/history/{{$user->_id}}">Lịch sử</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{$allUser->appends(['start' => $start, 'end'=>$end])->links()}}
            </div>
        </div>
    </div>
@endsection