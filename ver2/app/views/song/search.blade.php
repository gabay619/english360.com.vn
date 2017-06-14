@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/bai-hat.html">Bài hát tiếng anh</a></li>
                    </ul>
                </div>
                <div class="block search_dict">
                    <div class="block search_dict_alphabet">
                        <a href="/bai-hat/tim-kiem.html?letter=" @if($letter == '') class="active" @endif>...</a>
                        @for($i=0; $i <= 25; $i++)
                            <a href="/bai-hat/tim-kiem.html?letter={{strtoupper(Common::numtoalpha($i))}}" @if(strtoupper($letter) == strtoupper(Common::numtoalpha($i))) class="active" @endif>{{Common::numtoalpha($i)}}</a>
                        @endfor
                    </div>
                </div>
            </div>
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
                                Chưa có bài hát nào trong mục này.
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