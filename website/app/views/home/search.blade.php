@extends('layouts.detail')

@section('content')
    <div class="content_left">
        <div class="block">
            <div class="heading_cate">
                <ul class="list_heading_cate">
                    <li><a href="">Kết quả tìm kiếm với từ khóa "{{$keyword}}"</a></li>
                </ul>
            </div>
        </div>
        <div class="block">
            <div class="block_list_cate">

                <ul class="ul_block_list_cate">
                    @if(count($listLession) > 0)
                        @foreach($listLession as $item)
                            <li>
                                <div class="item4">
                                    <a href="{{$item['url']}}" title="">
                                        <span class="img_mask img_mask_item4">
                                            <img src="{{$item['avatar']}}">
                                        </span>
                                        <label class="mini_date">{{$item['date']}}</label>
                                        <label class="mini_tags">{{$item['cate']}}</label><br>
                                        <strong class="title_item5">{{$item['name']}}</strong>
                                        <label class="mini_short_text">{{$item['captions']}}</label>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <div class="item4">
                                Không tìm thấy kết quả nào.
                            </div>
                        </li>
                    @endif
                </ul>
                @if($totalPage > 1)
                    <ul class="pagination">
                        <li>
                            <a href="?page=1">Đầu</a>
                        </li>
                        @for($i = 1; $i<=$totalPage; $i++)
                            @if($page+5>=$i && $page-5 <= $i)
                                <li @if($i==$page) class="active" @endif>
                                    <a href="?keyword={{$keyword}}&page={{$i}}">{{$i}}</a>
                                </li>
                            @endif
                        @endfor
                        <li>
                            <a href="?page={{$totalPage}}">Cuối</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection