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
                        <li><a href="/{{CommonHelpers::getCateSlugbyType($type)}}.html">{{$cate['name']}}</a></li>
                        @if($childCate)
                        <li><a href="{{ThuVien::getCateUrl($childCate->_id, $childCate->name, $type)}}">{{$childCate->name}}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="detail_default">
                    <h1 class="heading4 heading_detail">
                        {{$item->name}}
                    </h1>
                    <div class="row behind_heading4">
                        <div class="left">
                            <label class="mini_date">{{isset($item->calendar) ? date('d/m/Y H:i', $item->calendar) : date('d/m/Y H:i', $item->datecreate)}}</label>
                        </div>
                        @if(!Network::is3g() || !Network::is3gmobifone())
                        <div class="right">
                            <div class="fb-like" data-href="{{Request::url()}}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true">
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(!empty($item->medialink))
                    <div class="url_video_area center row">
                        <div id="myElement">Loading the player...</div>
                    </div>
                    @endif
                    @if(in_array($type, array(Constant::TYPE_VIDEO, Constant::TYPE_RADIO, Constant::TYPE_FILM, Constant::TYPE_FAMOUS, Constant::TYPE_IDIOM)))
                    @emailbox($type)
                    @endif
                    @if(!empty($item->content['eng']) && !empty($item->content['vie']))
                    <div class="table_detail row table-scroll">
                        <table class="table_1" style="width: 100%">
                            <thead>
                            <tr>
                                <td style="color: red; text-align: center; text-transform: uppercase"><b>Tiếng Anh</b></td>
                                <td style="color: red; text-align: center; text-transform: uppercase"><b>Tiếng Việt</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            {{Common::formatTranslatecontent($item->content['eng'], $item->content['vie'])}}
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(in_array($type, array(Constant::TYPE_VIDEO, Constant::TYPE_RADIO, Constant::TYPE_FILM, Constant::TYPE_FAMOUS)) && !empty($item->tuvung))
                    <h4 class="title_1">Từ vựng</h4>
                    <div class="table_detail row">
                        {{$item->tuvung}}
                    </div>
                    @endif
                    @if(!in_array($type, array(Constant::TYPE_IDIOM)))
                    @if(in_array($type, array(Constant::TYPE_FAMOUS, Constant::TYPE_RADIO, Constant::TYPE_FILM, Constant::TYPE_VIDEO)) && !empty($item->lession))
                    <h4 class="title_1" style="margin-top: 15px">Cấu trúc</h4>
                    @endif
                    <div class="table_detail row">
                        {{$item->lession}}
                    </div>
                    @endif
                    @if(in_array($type, array(Constant::TYPE_EXP, Constant::TYPE_DAILY)))
                        @emailbox($type)
                    @endif
                    <div class="btn_bottom_dentail_default center">
                        <a href="javascript:saveExam()" class="btn_x btn_blue btn_luubaihoc">Lưu bài học</a>
                    </div>
                    @review($item->_id,$type)
                    <h4 class="title_1">
                        Bài viết liên quan
                    </h4>
                    <div class="relate_link">
                        @relatedposts($type, $item)
                    </div>
                    @commentbox($type, $item->_id)
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
            responsive: true,
            autostart: true,
            tracks: [{
                file: "{{isset($item->sub['eng']) ? $item->sub['eng'] : ''}}",
                label: "Anh",
                kind: "captions",
                "default": true
            },{
                file: "{{isset($item->sub['vie']) ? $item->sub['vie'] : ''}}",
                kind: "captions",
                label: "Việt"
            },{
                file: "{{isset($item->sub['engvie']) ? $item->sub['engvie'] : ''}}",
                kind: "captions",
                label: "Anh-Việt"
            }],
            captions: {
                {{Constant::PLAYER_SUB_CONFIG}}
            }
        });

        function saveExam(){
            $.post('/user/save-lession', {
                id: '{{$item->_id}}', type: '{{$type}}', return_url: window.location.href, _token : '{{ csrf_token() }}'
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
    {{--@regpopup()--}}
@endsection