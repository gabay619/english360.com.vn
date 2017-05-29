<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi_VN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/assets/web/images/favicon.png" type="image/x-icon"/>
    <title>{{isset($title)?$title:'Trang học tiếng Anh giao tiếp'}}</title>
    <meta name="description" content="{{isset($description)?$description:'Trang tiếng Anh giao tiếp mọi cấp độ, mọi lĩnh vực qua không gian của người bản ngữ: bài hát, phim, video, radio, thành ngữ, chuyện người nổi tiếng, tình huống giao tiếp'}}">
    <meta name="keywords" content="{{isset($keyword)?$keyword:'english360, english360.vn, english, tiếng anh, tự học tiếng anh, học tiếng anh, tiếng anh online, học tiếng anh trực tuyến, anh văn giao tiếp, học tiếng anh online, tiếng anh giao tiếp, luyện ngữ âm, luyện giao tiếp, học tiếng anh giao tiếp, giao tiếp tiếng anh, người nổi tiếng, clip người nổi tiếng, tiếng anh cơ bản, cách học tiếng anh giao tiếp, giao tiếp cơ bản, tiếng anh giao tiếp cơ bản, giao tiếp cơ bản tiếng anh, tiếng anh giao tiếp thương mại, tiếng anh công sở, tiếng anh chuyên ngành, bài hát tiếng anh, video học tiếng anh, audio tiếng anh, tiếng anh BBC, CNN, học tiếng anh qua phim, phim mỹ, phim tiếng anh, thành ngữ tiếng anh, học tiếng anh hàng ngày, trò chơi tiếng anh, kinh nghiệm học tiếng anh, từ điển chuyên ngành, hỏi đáp tiếng anh, '}}">
    <meta property="og:site_name" content="English360"/>
    <meta property="og:title" content="{{isset($title)?$title:'Trang học tiếng Anh giao tiếp'}}"/>
    <meta property="og:description" content="{{isset($description)?htmlentities($description):'Trang tiếng Anh giao tiếp mọi cấp độ, mọi lĩnh vực qua không gian của người bản ngữ: bài hát, phim, video, radio, thành ngữ, chuyện người nổi tiếng, tình huống giao tiếp'}}"/>
    <meta property="og:image" content="{{Constant::BASE_URL}}{{isset($avatar)?$avatar:'/uploads/og_fb.png'}}"/>
    <meta property="article:author" content="{{Constant::FACEBOOK_URL}}" />
    <meta property="article:publisher" content="{{Constant::FACEBOOK_URL}}" />
    <link href="/assets/web/css/normalize.css?v=29517" type="text/css" rel="stylesheet" media="all" />
    <link href="/assets/web/css/style.css" type="text/css" rel="stylesheet" media="all" />
    <link href="/assets/web/css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="/assets/web/css/jquery.bxslider.css" rel="stylesheet" />
    <link href="/assets/web/css/featherlight.min.css" rel="stylesheet" />
    <link href="/assets/web/css/tabModule.css" rel="stylesheet" type="text/css" />
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/lib/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/assets/lib/jwplayer-7.4.2/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="sP/q5QP+35gezFLCM/h47ykgSjaKjE0jUjCEfQ==";</script>
    <script src="/assets/js/jquery.min.js"></script>
    {{--<script src="/wapsite/as"></script>--}}
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/lib/jquery-ui/jquery-ui.min.js"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script src="/assets/js/blockUI.js"></script>
    <script src='https://code.responsivevoice.org/responsivevoice.js'></script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '285812458420953');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=285812458420953&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
</head>
<body>

    @include("layouts.ga")
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1539737363001576',
            xfbml      : true,
            version    : 'v2.7'
        });
    };

//    (function(d, s, id) {
//        var js, fjs = d.getElementsByTagName(s)[0];
//        if (d.getElementById(id)) return;
//        js = d.createElement(s); js.id = id;
//        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=1539737363001576";
//        fjs.parentNode.insertBefore(js, fjs);
//    }(document, 'script', 'facebook-jssdk'));

    FB.api('/me/likes?fields=id', function(response) {
        console.log(response);
        var our_page_id = '986816931397636';
        var user_is_fan = false;
        var likes_count = response.data.length;
        for(i = 0; i < likes_count; i++) {
            if(response.data[i].id === our_page_id) {
                user_is_fan = true;
                break;
            }
        }
        console.log(user_is_fan)
    });
</script>
<div class="header">
    <div class="w1170">
        <div class="top_header">
            <div class="top_logo">
                <a href="/" title="">
                    <img alt="english360.vn" src="/assets/web/images/logo_top.png"  />
                </a>
                {{--<img src="/assets/web/images/bg_noel_1.png" alt="" class="bg_noel_1">--}}
            </div>
            <div style="float: left; margin-left: 15px; max-width: 600px">
                @banner(Constant::BANNER_WEB_HEADER)
                {{--<a href="#" title="" style="width: 720px; height: 90px; display: block">--}}
                    {{--<img alt="english360.vn" src="/assets/images/banner_320x50.jpg" style="width: 100%; height: 100%;"  />--}}
                {{--</a>--}}
            </div>
            <div class="search_and_account">
                <div class="search_area">
                    <a href="/trang/gioi-thieu.html" class="btn btn-primary" style="margin-right: 15px">Giới thiệu</a>
                    <input type="text" placeholder="Tìm kiếm" id="txtKeywordSearch" value="{{Input::get('keyword')}}" />
                    <button class="btn_search" onclick="search()"><i class="fa fa-fw"></i></button>
                </div>
                <div class="account_area">
                    <div class="userlink">
                        @if(Auth::user())
                        <button class="userlink_btn">{{Auth::user()->getFullDisplayName()}}<i class="fa fa-fw"></i></button>
                        <div class="user_form">
                            <div class="block notifi_user">
                                <div class="left ava_left">
                                    <div class="avatar">
                                        <img src="{{Auth::user()->getDisplayAvatar()}}" />
                                    </div>
                                </div>
                                <div class="left user_notification">
                                    <p><a href="/user/notify" style="color: #333">Bạn có <strong>(0)</strong> thông báo mới</a></p>
                                </div>
                            </div>
                            <div class="block notifi_user">
                                {{Constant::CASH_NAME}} của bạn: <span style="font-weight: bold; color: #db2727">{{number_format(Auth::user()->getBalance())}}đ</span>
                                @if(Auth::user()->getPackageTime())
                                    <br>
                                Thời hạn khóa học: <span style="font-weight: bold; color: #db2727">{{date('d/m/Y',Auth::user()->getPackageTime())}}</span>
                                @endif
                                {{--<a href="/txn/charge" class="btn btn-primary btn-sm" style="padding: 0px 5px;float: right;">Nạp {{Constant::CASH_NAME}}</a>--}}
                            </div>
                            <div class="block user_control_link">
                                <a href="/user/package" title="">Đăng ký khóa học</a>
                                <a href="/user/reg-lession" title="">Đăng ký bài học</a>
                                <a href="/user/profile" title="">Cài đặt riêng tư</a>
                                <a href="/user/save-lession" title="">Bài học đã lưu</a>
                                <a href="/user/question" title="">Câu hỏi của bạn</a>
                                <a href="/user/logout" title="">Thoát</a>
                            </div>
                        </div>
                            @else
                            <button class="userlink_btn">Tài khoản <i class="fa fa-fw"></i></button>
                            <div class="user_form">
                                <h3 class="heading3">Đăng nhập</h3>
                                <span id="userAjaxMsg" style="color: red"></span>
                                <span><input type="text" class="input_1 input_uf"  placeholder="Email" id="txtPhone1"/></span>
                                <span><input type="password" class="input_1 input_uf"  placeholder="Mật khẩu" id="txtPassword1"/></span>
                                <span><input type="checkbox" checked />Ghi nhớ đăng nhập</span>
                                <span><a class="text-link" href="/user/forget-pass">Quên mật khẩu</a></span>
                                <span><a class="btn_x btn_blue btn_dangnhap" href="javascript:login();">Đăng nhập</a></span>
                                <span style="text-align: center">Hoặc đăng nhập bằng</span>
                                <span>
                                    <a href="/user/login?redirect=1" class="social-icon fb"></a>
                                    <a href="/gg-callback.html" class="social-icon gg"></a>
                                    {{--<a class="btn_x btn_blue btn_dangnhap" href="/user/login?redirect=1" style="background-color: rgb(64,93,155) !important;">Đăng nhập qua Facebook</a>--}}
                                </span>
                                <span><a class="text-link-2" data-featherlight="#fl1" href="/user/register">Tạo tài khoản mới</a></span>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#txtKeywordSearch').keyup(function(e){
            if(e.which==13 && $(this).val() != ''){
                search();
            }
        });
        @if(Auth::user())
        $('.userlink_btn').click(function(){
                $.post('/user/load-unread-notify', {
                    _token : '{{ csrf_token() }}'
                }, function(result){
                    $('.user_notification strong').html('('+result+')');
                });

                {{--$.post('/user/check-package', {--}}
                    {{--_token : '{{ csrf_token() }}'--}}
                {{--}, function(result){--}}
                    {{--if(result.success)--}}
                        {{--$('.user_control_link a:first-child').html('Thông tin gói cước');--}}
                {{--});--}}
        });


        @endif

        $('#txtPhone1, #txtPassword1').keyup(function(e){
                    $('#userAjaxMsg').html('');
        });

        $('#txtPassword1').keyup(function(e){
            if(e.which==13 && $(this).val() != ''){
                login();
            }
        });
    });

    function login(){
        email = $('#txtPhone1').val();
        password = $('#txtPassword1').val();
        $.post('/user/login', {
            email: email, password: password, _token : '{{ csrf_token() }}'
        }, function(result) {
            if(result.success){
                location.reload();
            }else{
                $('#userAjaxMsg').html(result.message);
                $('#txtPassword1').val('');
            }
        }, 'json');
    }

    function search(){
        keyword = $('#txtKeywordSearch').val();
        window.location.href = '/search?keyword='+keyword;
    }
</script>
@header_nav()