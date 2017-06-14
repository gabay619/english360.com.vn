@include('layouts._header')
<div class="content">
    <div class="w1170">
    <script type="text/javascript" src="/plugin/uploadify/jquery.uploadify.min.js?v=1452657377"></script>
    <link rel="stylesheet" type="text/css" href="/plugin/uploadify/uploadify.css" />

    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">{{isset($breadcrumb) ? $breadcrumb : 'Tài khoản'}}</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block">
                        <h4 class="title_1" style="padding-top: 5px">Xin chào, {{Auth::user()->getFullDisplayName()}}</h4>
                        <div class="tab tab-vert">
                            <div class="individual_avatar">
                                <div class="individual_avatar_mask">
                                    <img src="{{empty(Auth::user()->priavatar) ? '/assets/web/images/individual_avatar.png' : Auth::user()->priavatar}}" alt="Avatar" />
                                    {{--<a class="replace_avatar_btn"><i class="fa fa-fw"></i></a>--}}
                                    <input type="file" name="file_upload" id="file_upload" />
                                </div>
                            </div>
                            @private_tab()

                            <ul class="tab-content">
                                <li>
                                    @yield('content')
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--<script type="text/javascript" src="/assets/web/js/tabModule.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function() {
                $('#file_upload').uploadify({
                    swf: '/plugin/uploadify/uploadify.swf',
                    uploader: '/user/upload-avatar',
                    buttonText: 'UPLOAD ẢNH',
                    'onUploadSuccess': function (file, data, response) {
                        var obj = JSON.parse(data);
                        if (obj.status == 200) {
                            console.log(obj.file.path);
                            $('.individual_avatar_mask img').attr('src', obj.file.path);
                            $('#avatar').val(obj.file.path);
//                            $('#previewavatar').attr('src', obj.file.path);
//                            $('#previewavatar').fadeIn();

                        } else {
                            alert(obj.mss);
                        }
                    }
                });
            },100);
        });

    </script>

    @include('layouts.content_right')
    </div>
    </div>
    @include('layouts._footer')