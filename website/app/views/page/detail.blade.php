@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">{{$item ? $item->getName() : 'Lỗi'}}</a></li>
                    </ul>
                </div>
                <div class="detail_default">
                    @if($item)
                    <h2 class="heading4 heading_detail">
                        {{$item->getName()}}
                    </h2>
                    <div class="table_detail row" style="margin-top: 25px">
                        {{$item->content}}
                    </div>
                    @else
                    <h2 class="heading4 heading_detail">
                        Trang này không tồn tại.
                    </h2>
                    <div class="table_detail row" style="margin-top: 25px">
                        <a href="/" class="btn btn-primary">Về trang chủ</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection