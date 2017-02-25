@extends('layouts.private')
@section('content')
        <!--TAB CONTENT-->
        <div class="content_tab_text">
            <p><strong class="notice_1 uppercase color_red mgb10">CHỌN KHÓA HỌC</strong></p>
            <div class="list_bhdl block">
                <form action="">
                    <ul class="ul_block_list_cate">
                        @foreach($packages as $aPack)
                            <li>
                                <div class="item4">
                                    <label for="package_{{$aPack->_id}}">
                                        <input type="radio" name="package" value="{{$aPack->_id}}" id="package_{{$aPack->_id}}">
                                        <strong class="title_item5">{{$aPack->name}} - {{number_format($aPack->price)}}VNĐ</strong>
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </div>
@endsection