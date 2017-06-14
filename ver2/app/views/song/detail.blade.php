@extends('layouts.detail', array(
    'title' => $item->name,
    'description' => $item->captions,
    'avatar' => $item->avatar,
    'keyword'=>$item->keyword
))

@section('content')
    <link rel="stylesheet" type="text/css" href="/plugin/uploadify/uploadify.css" />

    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/bai-hat.html">Bài hát</a></li>
                        @if($childCate)
                        <li><a href="{{Song::getCateUrl($childCate)}}">{{$childCate->name}}</a></li>
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
                    <div class="url_video_area center row">
                        <div id="myElement">Loading the player...</div>
                    </div>
                    @emailbox()
                    <div class="table_detail row table-scroll">
                        <table class="table_1" style="width: 100%">
                            <thead>
                            <tr>
                                <td style="color: red; text-align: center; text-transform: uppercase"><b>Tiếng Anh</b></td>
                                <td style="color: red; text-align: center; text-transform: uppercase"><b>Tiếng Việt</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            {{Common::formatTranslatecontent($item->contents['eng'], $item->contents['vie'])}}
                            </tbody>
                        </table>
                    </div>
                    @if(!empty($item->tuvung))
                    <h4 class="title_1" style="margin-top: 15px">Từ vựng</h4>
                    <div class="table_detail row">
                        {{$item->tuvung}}
                    </div>
                    @endif
                    @if(!empty($item->lession))
                    <h4 class="title_1" style="margin-top: 15px">Cấu trúc</h4>
                    <div class="table_detail row">
                        {{$item->lession}}
                    </div>
                    @endif
                    <h4 class="title_1">Audio Upload</h4>
                    <div class="text-center" style="margin-bottom: 15px">
                        <audio id="useraudio" style="display: none" controls></audio>
                    </div>
                    <div class="audio_post_song_english block">
                        @if(Auth::user())
                        <div class="item_audio_post item_audio_post_upload">
                            <div class="box" style="position: relative">
                                <input type="file" name="file_upload" id="file_upload" class="inputfile inputfile-4"  />
                                <input type="file" name="file-5[]" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" multiple />
                                <label for="file-5" style="position: absolute; top: 0">
                                    <figure>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                        </svg>
                                    </figure>
                                    <span>Upload audio</span>
                                </label>
                            </div>
                        </div>
                        @endif
                        @foreach($allUpload as $aUpload)
                            <?php
                            $user = $aUpload->user();
                            ?>
                            @if($user)
                        <div class="item_audio_post" style="position: relative">
                            @if(Auth::user() && Auth::user()->_id == $user->_id)
                            <a href="javascript:void(0)" class="delUploadBtn" data-id="{{$aUpload->_id}}" style="position: absolute;top: 0;right: 0;padding: 2px;"><i class="glyphicon glyphicon-remove"></i></a>
                            @endif
                            <div class="img_mask img_mask_size_6">
                                <a href="javascript:playSong('{{$aUpload->path}}');" class="block">
                                    <img src="{{$user->getDisplayAvatar()}}">
                                    <label class="img_shadow"></label>
                                    <i class="btn_active_audio fa fa-fw"></i>
                                </a>
                            </div>
                            <div class="audio_author block">
                                {{--<h3>Happy New Year</h3>--}}
                                <h4>{{$user->getDisplayName()}}</h4>
                            </div>
                        </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="btn_bottom_dentail_default center">
                        <a href="javascript:saveExam()" class="btn_x btn_blue btn_luubaihoc">Lưu bài học</a>
                        <a href="/bai-hat/bai-tap.html?id={{$item->_id}}" class="btn_x btn_red btn_luubaihoc">Luyện tập</a>
                    </div>
                    @review($item->_id,Constant::TYPE_SONG)

                    <h4 class="title_1">
                        Bài viết liên quan
                    </h4>
                    <div class="relate_link">
                        @relatedposts(Constant::TYPE_SONG, $item)
                    </div>
                    @commentbox(Constant::TYPE_SONG, $item->_id)
                </div>
            </div>
        </div>
    </div>
    <style>
        .uploadify {
            /*background: rgba(0, 0, 0, 0.275) none repeat scroll 0 0;*/
            cursor: pointer;
            display: block;
            opacity: 0;
            height: 150px !important;
            /*position: absolute;*/
            text-align: center;
            /*width: 100% !important;*/
            z-index: 10;
            /* opacity: 0; */
            /*transition: all ease-in-out 0.15s;*/
            /*margin-left: 10px;*/
            margin: 0;
            padding-top: 50px;
            padding-left: 8px;
        }
        .uploadify object{
            left: 8px;
        }
        .uploadify:hover{
            opacity: 1;

        }
    </style>
    <script type="text/javascript" src="/plugin/uploadify/jquery.uploadify.min.js?v=1452657377"></script>

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

        function playSong(link){
            $('#useraudio').show();
            $('#useraudio').attr('src',link);
            $('#useraudio')[0].play();
        }

        function saveExam(){
            $.post('/user/save-lession', {
                id: '{{$item->_id}}', type: '{{Constant::TYPE_SONG}}', return_url: window.location.href, _token : '{{ csrf_token() }}'
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('.audio_post_song_english').on('click','.delUploadBtn',function(){
                if(confirm('Bạn muốn xóa bản thu này?')){
                    id = $(this).attr('data-id');
                    $obj = $(this).parent();
                    $.post('/ajax/del-upload', {
                        id:id
                    }, function(result){
                        if(result.success){
//                            console.log($obj)
                            $obj.remove();
                        }else{
                            alert(result.message);
                        }
                    })
                }
            });

            @if(Auth::user())
            setTimeout(function() {
                $('#file_upload').uploadify({
                    swf: '/plugin/uploadify/uploadify.swf',
                    uploader: '/upload/upload-song?id={{$item->_id}}',
                    buttonText: 'CHỌN FILE',
                    fileTypeExts: '*.mp3;*.wmv;*.ogg',
                    'onUploadSuccess': function (file, data, response) {
                        var obj = JSON.parse(data);
                        if (obj.status == 200) {
                            console.log(obj.file.path);
                            htmlx = '<div class="item_audio_post" style="position: relative">'+
                                    '<a href="javascript:void(0)" class="delUploadBtn" data-id="'+obj.file.index+'" style="position: absolute;top: 0;right: 0;padding: 2px;"><i class="glyphicon glyphicon-remove"></i></a>'+
                                    '<div class="img_mask img_mask_size_6">'+
                                    '<a href="javascript:playSong(\''+obj.file.path+'\');" class="block">'+
                                    '<img src="{{Auth::user()->getDisplayAvatar()}}">'+
                                    '<label class="img_shadow"></label>'+
                                    '<i class="btn_active_audio fa fa-fw"></i>'+
                                    '</a>'+
                                    '</div>'+
                                    '<div class="audio_author block">'+
                                    '<h4>{{Auth::user()->getDisplayName()}}</h4>'+
                                    '</div>'+
                                    '</div>';
//                            $('.individual_avatar_mask img').attr('src', obj.file.path);
//                            $('#avatar').val(obj.file.path);
//                            $('#previewavatar').attr('src', obj.file.path);
//                            $('#previewavatar').fadeIn();
                                $('.item_audio_post_upload').after(htmlx);
                        } else {
                            if(typeof obj.package != 'undefined'){
                                window.location.href = '/user/package';
                            }else
                                showMss(obj.mss);
                        }
                    }
                });
            },100);
            @endif
        });

    </script>
    @regpopup()
@endsection