<h3 class="game_h3 block center">Chủ đề khác</h3>
<div class="slider_list_subject_game block mgt10">
    <ul class="bxslider2">
        @foreach($allTopic as $aTopic)
        <li>
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
        </li>
        @endforeach
    </ul>
</div>