@extends('layouts.detail', array(
    'title' => $item->name,
    'description' => $item->captions,
    'avatar' => $item->avatar,
    'keyword'=>$item->keyword
))

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/ngu-phap.html">Ngữ pháp</a></li>
                    </ul>
                </div>
                <div class="detail_default">
                    <h1 class="heading4 heading_detail">
                        {{$item->name}}
                    </h1>
                    <div class="row behind_heading4">
                        <div class="left">
                            <label class="mini_date">{{date('d/m/Y', $item->datecreate)}}</label>
                        </div>
                        @if(!Network::is3g() || !Network::is3gmobifone())
                        <div class="right">
                            <div class="fb-like" data-href="{{Request::url()}}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="table_detail row">
                        {{$item->contents}}
                    </div>
                    <div class="btn_bottom_dentail_default center">
                        <a href="javascript:saveExam()" class="btn_x btn_blue btn_luubaihoc">Lưu bài học</a>
                        <a href="/ngu-phap/bai-tap.html?id={{$item->_id}}" class="btn_x btn_red btn_luubaihoc">Luyện tập</a>
                    </div>
                    @review($item->_id,Constant::TYPE_NGUPHAP)
                    <h4 class="title_1">
                        Bài viết liên quan
                    </h4>
                    <div class="relate_link">
                        @relatedposts(Constant::TYPE_NGUPHAP, $item)
                    </div>
                    @commentbox(Constant::TYPE_NGUPHAP, $item->_id)
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function saveExam(){
            $.post('/user/save-lession', {
                id: '{{$item->_id}}', type: '{{Constant::TYPE_NGUPHAP}}', return_url: window.location.href, _token : '{{ csrf_token() }}'
            }, function(result){
                if(result.success){
                    showMss(result.message);
                }else{
                    if(typeof result.package != 'undefined'){
                        window.location.href = '/user/package';
                    }else if(typeof result.login != 'undefined'){
                        window.location.href = '/user/login';
                    }else
                        showMss(result.message);
                }
            }, 'json')
        }
    </script>
    @regpopup()
@endsection