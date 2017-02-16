@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_game block">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Game</a></li>
                    </ul>
                </div>
                <div class="top_body_game block">
                    <div class="title_game block">
                        <h2 class="font_game block">Trò chơi</h2>
                    </div>
                </div>
                <div class="middle_body_game block">
                    <div class="label_game_2 block">
                        <img class="left" src="/assets/web/images/game/label_game_2.png" />
                        <img class="right" src="/assets/web/images/game/label_game_2.png" />
                    </div>
                    <div class="start_game_screen">
                        <div class="left">
                            <div class="img_game_1">
                                <img src="/assets/web/images/game/img_game_1.png" />
                            </div>
                            {{--<div class="share_game">--}}
                                {{--<a href="" class="btn_share_game right">--}}
                                    {{--<img src="/assets/web/images/game/btn_share_fb.png" />--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        </div>
                        <div class="right">
                            <h3 class="game_h3">Giải trí thú vị! Vừa học vừa chơi cùng Game Quiz tiếng anh bạn nhé !!!</h3>
                            <div class="label_game_1 block">
                                <a class="link_topnguoichoi font_game" href="/game/rank" ><img src="/assets/web/images/game/link_topnguoichoi.png" /></a>
                                <a class="link_huongdanchoi font_game" href="/game/guide" ><img src="/assets/web/images/game/link_huongdanchoi.png" /></a>
                            </div>
                            <div class="btn_game_area block center">
                                <a class="btn_game btn_game_1 font_game" href="/game/start">Bắt đầu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection