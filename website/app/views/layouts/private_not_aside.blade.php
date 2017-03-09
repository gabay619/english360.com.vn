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
                            <li><a href="/user/package">{{isset($breadcrumb) ? $breadcrumb : 'Tài khoản'}}</a></li>
                        </ul>
                    </div>
                    <div class="individual_control_page">
                        <div class="vertical_tab individual_tab block">
{{--                            <h4 class="title_1" style="padding-top: 5px">Xin chào, {{Auth::user()->getFullDisplayName()}}</h4>--}}
                            <div class="tab tab-vert">
                                {{--@private_tab()--}}

                                <ul class="">
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

        @include('layouts.content_right')
    </div>
</div>
@include('layouts._footer')