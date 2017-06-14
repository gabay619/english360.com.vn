<div class="block">
    <div class="heading2">
        <div class="title_heading2">
            <h2><a title="" href="javascript:void(0)">Bài học nổi bật</a></h2>
        </div>
    </div>
    <div class="block_categories_right">
        @if($firstLession)
        <div class="row_1">
            <div class="item1">
                <a title="{{$firstLession['name']}}" href="{{$firstLession['url']}}">
                    <div class="img_mask img_mask_size_3">
                        <img src="{{$firstLession['avatar']}}">
                        <label class="img_shadow"></label>
                        <strong class="title_item1 title_item1_font_2">{{$firstLession['name']}}</strong>
                    </div>
                </a>
            </div>
        </div>
        @endif
        <div class="row_2">
            <ul class="list_2_bhnt">
                @foreach($listLession as $aLession)
                <li>
                    <div class="item3">
                        <a title="{{$aLession['name']}}" href="{{$aLession['url']}}">
                            <span class="img_mask img_mask_item3">
                                <img src="{{$aLession['avatar']}}">
                            </span>
                            <label class="mini_tags">{{$aLession['cate']}}</label>
                            <strong class="title_item3 title_item2_font_1">{{$aLession['name']}}</strong>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div> <!--Block Categories Right / Bài học yêu thích-->