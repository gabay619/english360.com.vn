@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/bai-hat.html">Bài hát</a></li>
                    </ul>
                </div>
                <div class="detail_gtcb_lt block">
                    <h2 class="heading4 heading_detail">
                        Luyện tập bài hát: {{$item->name}}
                    </h2>
                    <div class="row behind_heading4">
                        <div class="left">
                            <label class="mini_date">{{date('d/m/Y H:i', $item->datecreate)}}</label>
                        </div>
                        <div class="right">
                        </div>
                    </div>
                    <div class="url_video_area center row">
                        <div id="myElement">Loading the player...</div>
                    </div>
                    @if($item->exam)
                        <div class="question_label_8 block">
                            <h4 class="title_1">Điền từ còn thiếu vào chỗ trống</h4>
                            {{--<div class="audio_player_area block center mgb20 mgt10">--}}
                                {{--<div class="audio-player">--}}
                                    {{--<audio controls="" type="audio/mp3" src="{{$dientu->medialink}}" id="audio-player"></audio>--}}
                                {{--</div><!-- @end .audio-player -->--}}
                            {{--</div>--}}
                            {{--<div class="list_tu_goi_y block">--}}
                            {{--</div>--}}
                            <div class="doanvan dientu">
                                {{$item->exam}}
                            </div>
                        </div>
                    @endif
                    <div class="btn_bottom_dentail_default center">
                        <a class="btn_x btn_blue btn_luubaihoc" href="javascript:complete()" id="btnComplete">Hoàn thành</a>
                        <a class="btn_x btn_red btn_luubaihoc" href="{{$item->getDetailUrl()}}" id="btnContinue" style="display: none">Quay lại bài học</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jwplayer("myElement").setup({
            file: "{{$item->medialink}}",
            image: "{{$item->avatar}}",
            skin: '{{Constant::PLAYER_SKIN}}',
            width: 650,
            height: 366,
            {{--tracks: [{--}}
                {{--file: "{{isset($item->sub['eng']) ? $item->sub['eng'] : ''}}",--}}
                {{--label: "English",--}}
                {{--kind: "captions",--}}
                {{--"default": true--}}
            {{--},{--}}
                {{--file: "{{isset($item->sub['vie']) ? $item->sub['vie'] : ''}}",--}}
                {{--kind: "captions",--}}
                {{--label: "Tiếng Việt"--}}
            {{--}],--}}
            captions: {
                color: '#fff',
//                fontSize: 20,
                backgroundOpacity: 50
            }
        });
        $(function(){
            var b = $('.dientu img.InputQuestion');
            $.each(b, function (i) {
                var kq = $(this).attr('alt');
                $(this).after('<input class="input_2 w150" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text"></span>');
                $(this).hide();
            })
        });

        function strip(html)
        {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function complete(){
//            if(!validateDientu()){
//                alert('Bạn chưa điền đầy đủ các từ còn thiếu.'); return false;
//            }
            dientuResult();
            $('#btnComplete').remove();
            $('#btnContinue').show();
        }

        function validateDientu(){
            result = true;
            $('.dientu input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });
            return result;
        }

        function dientuResult(){
            $('.dientu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                if(ans == trueans){
                    html = '<span class="result true">'+
                            trueans+'<i class="i_anw_true"></i>'+
                            '</span>';

                }else{
                    html = '<span class="result false">'+ans+
                            '</span>'+
                            '<span class="result true">'+
                            '<i class="i_anw_false"></i> '+ trueans+
                            '</span>'
                }
                $(this).after(html);
                $(this).remove();
            })
        }
    </script>
@endsection