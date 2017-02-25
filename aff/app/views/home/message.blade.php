@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Thông báo</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block">
                        <h4 class="title_1">Thông báo</h4>
                        @include('layouts._messages')
                        <a href="/" class="btn btn-lg btn-default">Trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection