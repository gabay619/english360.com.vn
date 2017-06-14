@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_game block">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/game">Game</a></li>
                    </ul>
                </div>
                <div class="top_body_game block">
                    <div class="title_game block">
                        <h2 class="font_game block">Bảng xếp hạng</h2>
                    </div>
                </div>
                <div class="middle_body_game block">
                    <div class="label_game_2 block">
                        <img class="left" src="/assets/web/images/game/label_game_2.png" />
                        <img class="right" src="/assets/web/images/game/label_game_2.png" />
                    </div>
                    <div class="high_score_game_screen block">
                        <div class="heading_game center mgb20 block">
                            <div class="btn_area btn left">
                                <a href="/game"><img src="/assets/web/images/game/btn_undo.png" /></a>
                            </div>
                            {{--<div class="game_h3">Bảng xếp hạng</div>--}}
                        </div>
                        <div class="list_high_score_game block">
                            @foreach($rank as $key=>$aRank)
                                <?php
                                $user = $aRank->user();
                                ?>
                                @if($user)
                            <div class="gamer_item">
                                <div class="stt_list_gamer">
                                    <label>{{$key+1}}</label>
                                </div>
                                <div class="name_gamer">
                                    <strong>{{$user->getDisplayname()}}</strong>
                                </div>
                                <div class="score_gamer">
                                    <label>{{$aRank->point}}</label>
                                </div>
                            </div>
                                @endif
                            @endforeach
                            <div class="btn_more_score_div center">
                                <a class="btn_game btn_game_4 btn_more_score font_game" href="">Điểm của bạn là {{$myPoint}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom_body_game block">
                    <div class="label_game_2 block">
                        <img src="/assets/web/images/game/label_game_2.png" class="left">
                        <img src="/assets/web/images/game/label_game_2.png" class="right">
                    </div>
                    @othertopicgame()
                </div>
            </div>
        </div>
    </div>
@endsection