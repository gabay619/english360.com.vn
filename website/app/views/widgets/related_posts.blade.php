<div class="slider1">
    @foreach($allRelated as $item)
    <div class="slide">
        <div class="item1">
            <a href="{{$item->getDetailUrl($type)}}">
                <div class="img_mask img_mask_size_6">
                    <img src="{{$item->avatar}}">
                    <label class="img_shadow"></label>
                    <strong class="title_item1 title_item1_font_3">{{$item->name}}</strong>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>
