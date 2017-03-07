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
    @datepicker($start, $end, '/dashboard')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="alert alert-success">
        <h2 style="margin: 0">Doanh thu: <strong>{{number_format($revenue)}}đ</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-mouse-pointer fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$click}}</div>
                            <div>Click</div>
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
                            <div class="huge">{{$countRevenue}}</div>
                            <div>Lượt thanh toán</div>
                        </div>
                    </div>
                </div>
                <a href="/report/txn?{{http_build_query(Input::all())}}">
                    <div class="panel-footer">
                        <span class="pull-left">Chi tiết</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$payRate}}%</div>
                            <div>Tỷ lệ thanh toán</div>
                        </div>
                    </div>
                </div>
                <a href="/report/txn?{{http_build_query(Input::all())}}">
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
@endsection