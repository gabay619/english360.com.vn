@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Dashboard <small>Statistics Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px">
        <div class="col-sm-12">
            {{Form::open(array('url'=>'#','method'=>'get','class'=>'form-inline','id'=>'datePick'))}}
            {{Form::hidden('start',null,array('id'=>'dateStart'))}}
            {{Form::hidden('end',null,array('id'=>'dateEnd'))}}
            <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                {{Form::text('range', $start.' - '.$end, array('class'=>'form-control','id'=>'reportrange'))}}
            </div>
            {{Form::close()}}
        </div>
    </div>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="alert alert-success">
        <h2 style="margin: 0">Số dư: <strong>{{number_format(Auth::user()->account()->balance)}}đ</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        {{--<div class="col-xs-3">--}}
                        {{--<i class="fa fa-money fa-5x"></i>--}}
                        {{--</div>--}}
                        <div class="col-xs-12 text-right">
                            <div class="huge">0đ</div>
                            <div>Doanh thu</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Chi tiết</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-mouse-pointer fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$click}}</div>
                            <div>CLICKS!</div>
                        </div>
                    </div>
                </div>
                <a href="/report/click?{{http_build_query(Input::all())}}">
                    <div class="panel-footer">
                        <span class="pull-left">Chi tiết</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">0</div>
                            <div>Lượt thanh toán</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Chi tiết</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$user}}</div>
                            <div>Khách hàng</div>
                        </div>
                    </div>
                </div>
                <a href="/report/user?{{http_build_query(Input::all())}}">
                    <div class="panel-footer">
                        <span class="pull-left">Chi tiết</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var start = '{{$start}}';
            var end = '{{$end}}';

            function cb(start, end) {
                $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $('#dateStart').val(start.format('DD/MM/YYYY'));
                $('#dateEnd').val(end.format('DD/MM/YYYY'))
                $('#datePick').submit();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, cb);
        });
    </script>
@endsection