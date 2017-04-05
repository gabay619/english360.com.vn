<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>English360 - Hệ thống tiếp thị liên kết </title>

    <!-- Bootstrap -->
    <link href="{{asset('media/aff/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Page -->
    <link href="{{asset('media/aff/css/style.css?v=2')}}" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="{{asset('media/aff/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab" rel="stylesheet">
    <script src="{{ asset('/jquery/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
</head>
<body>
<!--Navbar-->
@outsidemenu()

<!--Content-->
@yield('content')

<div class="container-fluid footer">
    <div class="row text-center">
        <p>Cơ quan chủ quản: Công ty TNHH Truyền thông IQ Việt Nam</p>
        <p>Địa chỉ: Tầng 2 tòa nhà Dinhle, 123B Trần Đăng Ninh, Dịch Vọng, Cầu Giấy, Hà Nội</p>
        <p>Email: <a href="mailto:cskh@english360.com.vn">cskh@english360.com.vn</a> - CSKH: (04) 32474175</p>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{--<script src="js/jquery-1.11.2.min.js"></script>--}}

<!-- Include all compiled plugins (below), or include individual files as needed -->
{{--<script src="js/bootstrap.js"></script>--}}
</body>
</html>
