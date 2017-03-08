<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>English360 - Hệ thống tiếp thị liên kết </title>

    <!-- Bootstrap Core CSS -->
    <link href="/media/admin-theme/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/media/admin-theme/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/media/admin-theme/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/media/admin-theme/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui-timepicker-addon.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-select/bootstrap-select.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    {{--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}

    <![endif]-->

    <script src="{{ asset('/jquery/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/daterangepicker/moment.min.js') }}"></script>
    {{--<script src="{{ asset('lib/jquery-ui/jquery-ui-timepicker-addon.js') }}"></script>--}}
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-tag-input/bootstrap-tagsinput.min.js') }}"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="{{ asset('lib/daterangepicker/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/daterangepicker/daterangepicker.css') }}" />

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">English360 Affiliate</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->email}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">
                            <i class="fa fa-fw fa-money"></i> Số dư: <strong>{{number_format(Auth::user()->getAccountBalance())}}đ</strong>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-fw fa-money"></i> Đóng băng: <strong class="text-info">{{number_format(Auth::user()->getAccountSealBalance())}}đ</strong>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="/user/profile"><i class="fa fa-fw fa-user"></i> Thông tin cá nhân</a>
                    </li>
                    <li>
                        <a href="/payment/info"><i class="fa fa-fw fa-credit-card"></i> Thông tin thanh toán</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="/user/logout"><i class="fa fa-fw fa-power-off"></i> Đăng xuất</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    @include('layouts.aside')
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">