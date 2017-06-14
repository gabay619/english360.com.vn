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
                        <h2 class="font_game block">Trò chơi</h2>
                    </div>
                </div>
                <div class="middle_body_game block">
                    <div class="label_game_2 block">
                        <img class="left" src="/assets/web/images/game/label_game_2.png" />
                        <img class="right" src="/assets/web/images/game/label_game_2.png" />
                    </div>
                    <div class="select_subject_game_screen block">
                        <div class="heading_game center mgb20 block">
                            <div class="btn_area btn left">
                                <a href="/game"><img src="/assets/web/images/game/btn_undo.png" /></a>
                            </div>
                            <div class="game_h3">Mời bạn lựa chọn chủ đề với mức độ Khó/Dễ</div>
                        </div>
                        <div class="list_subject_game block">
                            @foreach($allTopic as $aTopic)
                            <div class="subject_game_item">
                                <div class="img_mask img_mask_avatar_subject_game_item">
                                    <a href=""><img src="{{$aTopic->avatar}}" /></a>
                                    <div class="level_game_position">
                                        <div class="level_game block">
                                            <div class="level_game_list">
                                                <a href="{{Game::getCateHardUrl($aTopic)}}" class="level_hard btn_level">Khó</a>
                                                <a href="{{Game::getCateEasyUrl($aTopic)}}" class="level_easy btn_level">Dễ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="title_subject_game_item block">
                                    <h2><a href="" class="font_game">{{$aTopic->name}}</a></h2>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection