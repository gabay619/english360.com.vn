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
                        <li><a href="/luyen-ngu-am.html">Ngữ âm</a></li>
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
                    <div class="url_video_area center row">
                        <div id="myElement">Loading the player...</div>
                    </div>
                    <div class="table_detail row">
                        {{$item->contents}}
                    </div>
                    <div class="btn_bottom_dentail_default center">
                        <a href="javascript:saveExam()" class="btn_x btn_blue btn_luubaihoc">Lưu bài học</a>
                        <a href="/luyen-ngu-am/bai-tap.html?id={{$item->_id}}" class="btn_x btn_red btn_luubaihoc">Luyện tập</a>
                    </div>
                    @review($item->_id,Constant::TYPE_LUYENNGUAM)
                    <h4 class="title_1">
                        Bài viết liên quan
                    </h4>
                    <div class="relate_link">
                        @relatedposts(Constant::TYPE_LUYENNGUAM, $item)
                    </div>
                    @commentbox(Constant::TYPE_LUYENNGUAM, $item->_id)
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jwplayer("myElement").setup({
            file: "{{$item->medialink}}",
            image: "{{$item->avatar}}",
            skin: '{{Constant::PLAYER_SKIN}}',
            width: 650,
            height: 366,
            autostart: true,
            tracks: [{
                file: "{{isset($item->sub['eng']) ? $item->sub['eng'] : ''}}",
                label: "English",
                kind: "captions",
                "default": true
            },{
                file: "{{isset($item->sub['vie']) ? $item->sub['vie'] : ''}}",
                kind: "captions",
                label: "Tiếng Việt"
            },{
                file: "{{isset($item->sub['engvie']) ? $item->sub['engvie'] : ''}}",
                kind: "captions",
                label: "Song ngữ"
            }],
            captions: {
                {{Constant::PLAYER_SUB_CONFIG}}
             }
        });

        function saveExam(){
            $.post('/user/save-lession', {
                id: '{{$item->_id}}', type: '{{Constant::TYPE_LUYENNGUAM}}', return_url: window.location.href, _token : '{{ csrf_token() }}'
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