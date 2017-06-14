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
                    <div class="answer_game_screen block">
                        <div class="heading_game center mgb20 block">
                            <div class="btn_area btn left">
                                <a href="/game/start"><img src="/assets/web/images/game/btn_undo.png" /></a>
                            </div>
                            <div class="right">
                                <span class="span_level btn_game font_game btn_game_1">Level {{$quiz->level}}</span>
                            </div>
                        </div>
                        <h3 class="game_h3 center" id="gameMessage">Xin chúc mừng ! Bạn đã trả lời đúng {{$trueCount}}/10 câu hỏi của Level {{$quiz->level}}</h3>
                        <div class="list_answer_checked block">
                            @foreach($quiz->question as $key=>$aQuestion)
                            @if(CommonHelpers::checkAnswerQuiz($aQuestion['aw'], $select[$key]))
                            <div class="item_answer_checked true">
                                <a class="btn_game_3 btn_item_answer_checked" href="javascript:void(0);">{{$key+1}}</a>
                                <span class="status_answer_check"></span>
                            </div>
                            @else
                            <div class="item_answer_checked false">
                                <a class="btn_game_3 btn_item_answer_checked" data-featherlight="#f{{$key}}" href="javascript:void(0);">{{$key+1}}</a>
                                <span class="status_answer_check"></span>
                            </div>
                            <div class="lightbox lightbox_game" id="f{{$key}}">
                                <!--<h2 class="heading_lightbox">Đăng ký tài khoản</h2>-->
                                <div class="content_lightbox">
                                    <div class="content_view_answer_game">
                                        <div class="heading_view_answer center">
                                            <p>Đáp án hình {{$key+1}}</p>
                                        </div>
                                        <div class="middle_body_game block">
                                            <div class="images_question_game_area block">
                                                <div class="images_question_game">
                                                    <span class="img_mask img_mask_question_game">
                                                        <img src="{{$aQuestion['avatar']}}">
                                                    </span>
                                                    <div class="describe_img_question_game">
                                                        <p>Hình {{$key+1}}</p>
                                                    </div>
                                                    {{--<div class="images_question_game_control">--}}
                                                        {{--<div class="prev_images_question"></div>--}}
                                                        {{--<div class="next_images_question"></div>--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                            @if($quiz->degree == Constant::LEVEL_EASY)
                                            <div class="list_answer_game block center checked">
                                                @foreach($aQuestion['select'] as $aSelect)
                                                    @if(CommonHelpers::checkAnswerQuiz($aQuestion['aw'], $aSelect))
                                                    <a class="btn_game btn_game_4 true" href="javascript:void(0)">{{$aSelect}}</a>
                                                    @elseif(CommonHelpers::checkAnswerQuiz($select[$key], $aSelect))
                                                        <a class="btn_game btn_game_3_select" href="javascript:void(0)">{{$aSelect}}</a>
                                                    @else
                                                        <a class="btn_game btn_game_3" href="javascript:void(0)">{{$aSelect}}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @else
                                                <div class="list_answer_game block center checked">
                                                    <a class="btn_game btn_game_4 true" href="javascript:void(0)">{{ $aQuestion['aw']}}</a>
                                                    <a class="btn_game btn_game_3_select" href="javascript:void(0)">{{ $select[$key]}}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="center">
                            <p>Mẹo: Bạn có thể click vào câu trả lời sai để xem đáp án của câu đó</p>
                        </div>
                        <div class="btn_game_area block center">
                            <a href="{{$quiz->degree == Constant::LEVEL_EASY ? Game::getCateEasyUrl($category) : Game::getCateHardUrl($category)}}" class="btn_game btn_game_2 font_game">Tiếp tục nào</a>
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