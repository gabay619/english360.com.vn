<div class="highlight_left">
    <ul class="bxslider">
        @foreach($slideList as $aSlide)
            @if($aSlide)
        <li>
            <div class="item1">
                <a href="{{$aSlide['url']}}">
                    <div class="img_mask img_mask_size_1">
                        <img src="{{$aSlide['avatar']}}">
                        <label class="img_shadow"></label>
                        <strong class="title_item1 title_item1_font_1">{{$aSlide['name']}}</strong>
                    </div>
                </a>
            </div>
        </li>
            @endif
        @endforeach
    </ul>
</div>
<div class="highlight_right">
    <ul class="list_highlight_right">
        @foreach($listLession as $aLession)
        <li>
            <div class="item1">
                <a href="{{$aLession['url']}}">
                    <div class="img_mask img_mask_size_4">
                        <img src="{{$aLession['avatar']}}">
                        <label class="img_shadow"></label>
                        <strong class="title_item1 title_item1_font_3">{{$aLession['name']}}</strong>
                    </div>
                </a>
            </div>
        </li>
        @endforeach
    </ul>
</div>

