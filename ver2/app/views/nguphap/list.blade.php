@extends('layouts.detail', array(
    'title' => 'Ngữ pháp'
))

@section('content')
    <div class="content_left">
        <div class="block">
            <div class="heading_cate">
                <h2><strong>Ngữ pháp</strong><label class="label_heading_cate"></label></h2>
                <ul class="list_heading_cate">
                    @foreach($allNpCategories as $aCate)
                        <li><a href="{{NguPhap::getCateUrl($aCate)}}" title="">{{$aCate->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="block_highlight_index">
                <div class="highlight_left">
                    <ul class="bxslider">
                        @foreach($slide as $aSlide)
                            <li>
                                <div class="item1">
                                    <a href="{{NguPhap::getStaticDetailUrl($aSlide['name'], $aSlide['_id'])}}">
                                        <div class="img_mask img_mask_size_1">
                                            <img src="{{$aSlide['avatar']}}" />
                                            <label class="img_shadow"></label>
                                            <strong class="title_item1 title_item1_font_1">{{$aSlide['name']}}</strong>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="highlight_right">
                    <ul class="list_highlight_right">
                        @foreach($hightlight as $item)
                            <li>
                                <div class="item1">
                                    <a href="{{NguPhap::getStaticDetailUrl($item['name'], $item['_id'])}}">
                                        <div class="img_mask img_mask_size_4">
                                            <img src="{{$item['avatar']}}">
                                            <label class="img_shadow"></label>
                                            <strong class="title_item1 title_item1_font_3">{{$item['name']}}</strong>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div> <!--Block Highlight-->
        </div>
        <div class="block">
            <div class="block_list_cate">

                <ul class="ul_block_list_cate">
                    @if(count($list) > 0)
                        @foreach($list as $item)
                            <li>
                                <div class="item4">
                                    <a href="{{$item->getDetailUrl()}}" title="">
                                        <span class="img_mask img_mask_item4">
                                            <img src="{{$item->avatar}}">
                                        </span>
                                        <label class="mini_date">{{date('d/m/Y', $item->datecreate)}}</label>
                                        <strong class="title_item5">{{$item->name}}</strong>
                                        <label class="mini_short_text">{{$item->captions}}</label>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <div class="item4">
                                Chưa có bài đăng nào trong mục này.
                            </div>
                        </li>
                    @endif
                </ul>
                <div class="btn_xemthem_cate">
                    {{$list->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection