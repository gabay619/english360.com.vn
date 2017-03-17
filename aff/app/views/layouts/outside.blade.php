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
    {{--<script src="{{ asset('lib/jquery-ui/jquery-ui-timepicker-addon.js') }}"></script>--}}
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-tag-input/bootstrap-tagsinput.min.js') }}"></script>

</head>

<body>

<div>

    @outsidemenu()

    <div id="page-wrapper">

        <div class="container-fluid">
@yield('content')
@include('layouts._footer')