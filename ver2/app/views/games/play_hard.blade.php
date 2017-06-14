@extends('layouts.detail')

@section('content')
    @if($quiz)
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
                        <h2 class="font_game block">{{$cate->name}}</h2>
                    </div>
                </div>
                <div class="middle_body_game block">
                    <div class="label_game_2 block">
                        <img class="left" src="/assets/web/images/game/label_game_2.png" />
                        <img class="right" src="/assets/web/images/game/label_game_2.png" />
                    </div>
                    <div class="playing_game_screen block">
                        <div class="heading_game center mgb20 block">
                            <div class="btn_area btn left">
                                <a href="/game/start"><img src="/assets/web/images/game/btn_undo.png" /></a>
                            </div>
                            <div class="right">
                                <span class="span_level btn_game font_game btn_game_1">Level {{$quiz->level}}</span>
                                <span class="btn_ht_area">
                                    <a href="javascript:getResult();" class="btn_game_2 btn_game font_game">Hoàn thành</a>
                                </span>
                            </div>
                        </div>
                        @foreach($quiz->question as $key=>$aQuestion)
                        <div class="images_question_game_area block" style="display: none" data-id="{{$key}}">
                            <div class="images_question_game">
                                    	<span class="img_mask img_mask_question_game">
                                        	<img src="{{$aQuestion['avatar']}}" />
                                        </span>
                                <div class="describe_img_question_game">
                                    <p>Hình {{$key+1}}</p>
                                </div>
                                <div class="images_question_game_control">
                                    <div class="prev_images_question" onclick="showItem({{$key-1}})"></div>
                                    <div class="next_images_question" onclick="showItem({{$key+1}})"></div>
                                </div>
                            </div>
                        </div>
                        <div class="list_answer_game block center" data-id="{{$key}}">
                            @for($i=0; $i<strlen($aQuestion['aw']); $i++)
                            <input class="ip_item_answer_game btn_game_3" maxlength="1" style="text-transform: uppercase"/>
                            @endfor
                        </div>
                        {{--<div class="true_answer block center">--}}
                            {{--<h3 class="game_h3">Why</h3>--}}
                        {{--</div>--}}
                        @endforeach
                    </div>

                </div>
                <div class="bottom_body_game block">
                    <div class="label_game_2 block">
                        <img src="/assets/web/images/game/label_game_2.png" class="left">
                        <img src="/assets/web/images/game/label_game_2.png" class="right">
                    </div>
                    @othertopicgame($cate->_id)
                </div>
            </div>
        </div>
    </div>
    <form action="/game/result/{{$quiz->_id}}" method="post" id="form-result">
        <input type="hidden" name="category" value="{{$cate->_id}}">
    </form>
    <script>
        var item_show = 0;
        $(function(){
            showItem(item_show);
//            $('.btn_answer').click(function(){
//                $(this).parent().find('.btn_answer').removeClass('select').removeClass('btn_game_4').addClass('btn_game_3');
//                $(this).addClass('select').addClass('btn_game_4').removeClass('btn_game_3');
//            });

            $('.list_answer_game input').keyup(function(){
                if($(this).val() != '')
                    $(this).next().focus();
            });
        });

        function showItem(i){
            if(i<0 || i>9){
                alert('Mỗi level chỉ có 10 câu hỏi.');return false;
            }

            $('.images_question_game_area').hide();
            $('.list_answer_game').hide();
            $('.images_question_game_area').eq(i).show();
            $('.list_answer_game').eq(i).show();
            $('.list_answer_game input:first-child').focus();
        }

        function getResult(){
            var select = [];
            var complete = true;
            $('.list_answer_game').each(function(e){
                choose = '';
                $(this).find('input').each(function(el){
                    if($(this).val() == '')
                        complete = false;
                    choose += $(this).val();
                });
                if(choose.length != 0)
                    select[e] = choose;
            });
            console.log(select);
            if(!complete){
                alert('Bạn phải điền vào tất cả các ô trống.');
                return false;
            }
            for (index = 0; index < select.length; ++index) {
                html = '<input type="hidden" name="select['+index+']" value="'+select[index]+'"/>';
//                console.log(html);
                $('#form-result').append(html);
            }

            $('#form-result').submit();
        }
    </script>
    @else
        <div class="content_left pd_20">
            <div class="block">
                <div class="block_game block">
                    <div class="breadcrum">
                        <ul class="ul_breadcrum">
                            <li><a href="">Trang chủ</a></li>
                            <li><a href="">Game</a></li>
                        </ul>
                    </div>
                    <div class="top_body_game block">
                        <div class="title_game block">
                            <h2 class="font_game block">{{$cate->name}}</h2>
                        </div>
                    </div>
                    <div class="middle_body_game block">
                        <div class="label_game_2 block">
                            <img class="left" src="/assets/web/images/game/label_game_2.png" />
                            <img class="right" src="/assets/web/images/game/label_game_2.png" />
                        </div>
                        <div class="playing_game_screen block">
                            <div class="heading_game center mgb20 block">
                                <div class="btn_area btn left">
                                    <a href="/game/start"><img src="/assets/web/images/game/btn_undo.png" /></a>
                                </div>
                                <div class="game_h3">Chúc mừng bạn đã hoàn thành tất cả các LEVEL trong chủ đề này!</div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom_body_game block">
                        <div class="label_game_2 block">
                            <img src="/assets/web/images/game/label_game_2.png" class="left">
                            <img src="/assets/web/images/game/label_game_2.png" class="right">
                        </div>
                        @othertopicgame($cate->_id)
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function(){
                setTimeout(function(){
                    window.location.href = '/game/start';
                },5000);
            })
        </script>
    @endif
@endsection