<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/media/admin-theme/css/bootstrap.min.css" rel="stylesheet">

    <!-- Website CSS style -->
{{--<link rel="stylesheet" type="text/css" href="assets/css/main.css">--}}

<!-- Website Font style -->
    <link href="/media/admin-theme/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Baloo' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

    <title>{{isset($title)?$title:'English360 - Hệ thống tiếp thị liên kết'}}</title>
</head>
<body>
<style>
    body, html{
        height: 100%;
        background-repeat: no-repeat;
        background-color: #d3d3d3;
        /*font-family: 'Oxygen', sans-serif;*/
    }

    h1.title {
        font-size: 50px;
        font-family: 'Baloo', cursive;
        font-weight: 400;
    }

    hr{
        width: 10%;
        color: #fff;
    }

    .form-group{
        margin-bottom: 15px;
    }

    label{
        margin-bottom: 15px;
    }

    input,
    input::-webkit-input-placeholder {
        font-size: 11px;
        padding-top: 3px;
    }

    .main-login{
        background-color: #fff;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

    }

    .main-center{
        margin-top: 30px;
        margin: 0 auto;
        max-width: 330px;
        padding: 40px 40px;

    }

    .login-button{
        margin-top: 5px;
    }

    .login-register{
        font-size: 11px;
        text-align: center;
    }

    /* social icon */
    .social-icon{
        display: inline-block;
        margin: 3px;
        width: 60px;
        height: 60px;
    }
    .social-icon.fb{
        background: url(http://english360.com.vn/assets/images/socials-icon.png) no-repeat;
    }
    .social-icon.gg{
        background: url(http://english360.com.vn/assets/images/socials-icon.png) no-repeat;
        background-position: 0 -59px;
    }
</style>
<div class="container">
    <!-- Navigation -->
    @outsidemenu()
    <div class="row main">
        @yield('content')
    </div>
    <div class="footer" style="text-align: center; padding: 20px">
        <p>Cơ quan chủ quản: Công ty TNHH Truyền thông IQ Việt Nam</p>
        <p>Địa chỉ: Tầng 2 tòa nhà Dinhle, 123B Trần Đăng Ninh, Dịch Vọng, Cầu Giấy, Hà Nội</p>
        <p>Email: <a href="mailto:cskh@english360.com.vn">cskh@english360.com.vn</a> - CSKH: (04) 32474175</p>
    </div>
</div>
@chatbox()
<script src="{{ asset('/jquery/jquery-2.1.0.min.js') }}"></script>

<script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>