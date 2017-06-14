@extends('layouts.detail')

@section('content')
    <?php $countTitle = 1 ?>
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/luyen-ngu-am.html">Ngữ âm</a></li>
                    </ul>
                </div>
                <div class="detail_gtcb_lt block">
                    <h2 class="heading4 heading_detail">
                        Luyện tập {{$post->name}}
                    </h2>
                    <div class="row behind_heading4">
                        <div class="left">
                            <label class="mini_date">{{date('d/m/Y H:i', $post->datecreate)}}</label>
                        </div>
                        <div class="right">
                        </div>
                    </div>
                    @if($dienchu)
                    <div class="question_label_6 block dienchu">
                        <h4 class="title_1" style="margin-bottom: 15px; text-transform: initial">{{Common::numberToRoman($countTitle++)}}. {{$dienchu->name}}</h4>
                        @foreach($dienchu->question as $key=>$aDienchu)
                        <div class="item_ql6 item_dienchu" data-answer="{{$aDienchu['aw']}}">
                            <div class="q_iql6">
                                <p>
                                    <label class="count-numb">{{$key+1}}</label>
                                    <span class="has-answer">{{str_replace('_', '<input type="text" class="input_2 w20" maxlength="1" style="text-transform: inherit" />', $aDienchu['short']);}}</span>
                                </p>
                            </div>
                            <div class="btn_start_listen">
                                <a href="javascript:playAudio('{{$aDienchu['audio']}}')"><i class="fa fa-fw"></i></a>
                            </div>
                            {{--<div class="result true">--}}
                                {{--<div class="i_anw_true"></div>--}}
                            {{--</div>--}}
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if(count($xemtranh) > 0)
                    <div class="question_label_7 block">
                        <h4 class="title_1" style="text-transform: initial">{{Common::numberToRoman($countTitle++)}}. Nghe và xem tranh gợi ý để điền từ vào chỗ trống</h4>
                        @foreach($xemtranh as $key=>$aXemtranh)
                        <div class="item_ql7">
                            <div class="a_goiy">
                                <img src="{{$aXemtranh->avatar}}" />
                            </div>
                            <div class="i_iql7 block">
                                <div class="xyz xemtranh">
                                    <label class="count-numb">{{$key+1}}</label>
                                    <span class="sp_get_input">
                                        <input class="input_2 w150" data-answer="{{$aXemtranh->aw}}" />
                                    </span>
                                    <div class="btn_start_listen">
                                        <img class="Loa" src="../resource/images/icon_audio.png" alt="{{$aXemtranh->medialink}}">
                                    </div>
                                    {{--<div class="result true">--}}
                                        {{--<div class="i_anw_true"></div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if(count($tracnghiem) > 0)
                    <div class="question_label_1 block">
                        <h4 class="title_1" style="text-transform: initial">{{Common::numberToRoman($countTitle++)}}. {{$tracnghiem->first()->name}}</h4>
                        @foreach($tracnghiem as $key=>$aTracnghiem)
                        <div class="item_ql1 block" style="float:left; width: 50%">
                            <strong class="block">
                                {{$key+1}}.
                            </strong>
                            <div class="list_anws_item_ql1 block tracnghiemAns" data-true="{{$aTracnghiem->trueaw}}">
                                @foreach($aTracnghiem->aw as $k=>$aAns)
                                <div class="item_anws_item_ql1 checkbox_css3 block">
                                    <input id="check_{{$key}}_{{$k}}" type="checkbox" value="check{{$k}}" name="check">
                                    <label for="check_{{$key}}_{{$k}}">{{$aAns}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($phatam)
                    <div class="question_label_6 question_label_6_fix block">
                        <h4 class="title_1" style="margin-bottom: 15px; text-transform: initial">{{Common::numberToRoman($countTitle++)}}. {{$phatam->name}}</h4>
                        @foreach($phatam->question as $key=>$aPhatam)
                        <div class="item_ql6 phatam">
                            <div class="q_iql6">
                                <p>
                                    <label class="count-numb">{{$key+1}}</label>{{$aPhatam['spelling']}}
                                    <span class="sp_get_input">
                                        <input class="input_2 w150" data-answer="{{$aPhatam['word']}}" />
                                    </span>
                                </p>
                            </div>
                            <div class="btn_start_listen">
                                <a href="javascript:playAudio('{{$aPhatam['audio']}}')"><i class="fa fa-fw"></i></a>
                            </div>
                            {{--<div class="result false">--}}
                                {{--<div class="i_anw_false"></div>--}}
                                {{--<strong>home</strong>--}}
                            {{--</div>--}}
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($dientu)
                    <div class="question_label_8 block">
                        <h4 class="title_1" style="text-transform: initial">{{Common::numberToRoman($countTitle++)}}. {{$dientu->name}}</h4>
                        <div class="audio_player_area block center mgb20 mgt10">
                            <div class="audio-player">
                                <audio controls="" type="audio/mp3" src="{{$dientu->medialink}}" id="audio-player"></audio>
                            </div><!-- @end .audio-player -->
                        </div>
                        <div class="list_tu_goi_y block">
                        </div>
                        <div class="doanvan dientu">
                            {{$dientu->contents}}
                        </div>
                    </div>
                    @endif
                    <div class="btn_bottom_dentail_default center">
                        <a class="btn_x btn_blue btn_luubaihoc" href="javascript:complete()" id="btnComplete">Hoàn thành</a>
                        <a class="btn_x btn_red btn_luubaihoc" href="{{$post->getDetailUrl()}}" id="btnContinue" style="display: none">Quay lại bài học</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.item_anws_item_ql1 input').change(function(){
                $(this).parent().parent().find('input').not($(this)).prop('checked', false);
            });

            var a = $('.dienchu img.InputQuestion');
            $.each(a, function (i) {
                var kq = $(this).attr('alt');
                var kqArr = kq.split('');
                for(index=0; index<kq.length; index++){
                    $(this).after('<input class="input_2 w20" maxlength="1" data-aw="' + kqArr[index].toLowerCase() + '" data-full="' + kqArr[index] + '" type="text"></span>');
                }
                $(this).hide();
            });

            var b = $('.dientu img.InputQuestion');
            var dientuArr = [];
            $.each(b, function (i) {
                var kq = $(this).attr('alt');
                dientuArr[dientuArr.length] = kq;
                $(this).after('<input class="input_2 w150" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text"></span>');
                $(this).hide();
            })
            shuffle(dientuArr);
            for(i=0; i< dientuArr.length; i++){
                $('.list_tu_goi_y').append('<span>'+dientuArr[i]+'</span>');
            }

            $('.dienchu input').keyup(function(){
                if($(this).val() != '')
                    $(this).next('.dienchu input').focus();
            })
        });

        function shuffle(array) {
            var currentIndex = array.length, temporaryValue, randomIndex;

            // While there remain elements to shuffle...
            while (0 !== currentIndex) {

                // Pick a remaining element...
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                // And swap it with the current element.
                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }

        function strip(html)
        {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function complete(){
//            if(!validateDienchu()){
//                alert('Bạn chưa hoàn thành bài tập điền chữ cái.'); return false;
//            }
//            if(!validateXemtranh()){
//                alert('Bạn chưa hoàn thành bài tập đoán chữ theo tranh.'); return false;
//            }
//            if(!validateTracnghiem()){
//                alert('Bạn chưa hoàn thành bài tập trắc nghiệm.'); return false;
//            }
//            if(!validatePhatam()){
//                alert('Bạn chưa hoàn thành bài tập nghe phát âm đoán chữ.'); return false;
//            }
//            if(!validateDientu()){
//                alert('Bạn chưa hoàn thành bài tập nghe đoạn hội thoại điền từ.'); return false;
//            }
            dienchuResult();
            xemtranhResult();
            phatamResult();
            tracnghiemResult();
            dientuResult();
            $('#btnComplete').remove();
            $('#btnContinue').show();
        }

        function validateDienchu(){
            result = true;
            $('.dienchu input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });
            return result;
        }

        function dienchuResult(){
            $('.item_dienchu').each(function(){
                var kq = $(this).attr('data-answer');
                var ans = '';

                $(this).find('span.has-answer input').each(function(){
                    $(this).after('<b>'+$(this).val()+'</b>');
                    $(this).remove();
                });
                var ans = strip($(this).find('span.has-answer').html());
                console.log(ans);
                if(kq.toLowerCase() == ans.toLowerCase()){
                    html = '<span class="result true">'+
                            '<i class="i_anw_true"></i>'+
                            '</span>';
                    $(this).find('span.has-answer b').addClass('text-success');
                }else{
                    html = '<span class="result false">'+
                            '<i class="i_anw_false"></i><strong>'+kq+'</strong>'
                            '</span>';
                    $(this).find('span.has-answer b').addClass('text-danger');

//                    $(this).append('<b class="text-danger">'+ans+'</b>');
                }
                $(this).append(html);
            });
        }

        function validateXemtranh(){
            result = true;
            $('.xemtranh input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });
            return result;
        }

        function xemtranhResult(){
            $('.xemtranh').each(function(){
                var kq = $(this).find('input').attr('data-answer');
                var ans = $(this).find('input').val();
                $(this).find('input').prop('disabled', true);
                if(kq.toLowerCase() == ans.toLowerCase()){
                    html = '<span class="result true">'+
                            '<i class="i_anw_true"></i>'+
                            '</span>';
                }else {
                    html = '<span class="result false">' +
                            '<i class="i_anw_false"></i><strong>' + kq + '</strong>'
                    '</span>';
                }
                $(this).append(html);
            });
        }

        function validateTracnghiem(){
            @if(count($tracnghiem) > 0)
            result = true;
            $('.tracnghiemAns').each(function(){
                result = false;
                $(this).find('input').each(function(){
                    if($(this).is(':checked')){
                        result = true;
                    }
                })
            })
            @else
            result = true;
            @endif

            return result;
        }

        function tracnghiemResult(){
            $('.tracnghiemAns').each(function(){
                trueans = $(this).attr('data-true');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    if(index == trueans){
                        $(this).find('label').addClass('lb_anw_true');
                    }else if($(this).find('input').is(':checked') && index != trueans){
                        $(this).find('label').addClass('lb_anw_false');
                    }
                    $(this).find('input').prop('disabled', true);
                });
            })
        }

        function validatePhatam(){
            result = true;
            $('.phatam input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });
            return result;
        }

        function phatamResult(){
            $('.phatam').each(function(){
                var kq = $(this).find('input').attr('data-answer');
                var ans = $(this).find('input').val();
                $(this).find('input').prop('disabled', true);
                if(kq.toLowerCase() == ans.toLowerCase()){
                    html = '<span class="result true">'+
                            '<i class="i_anw_true"></i>'+
                            '</span>';
                }else {
                    html = '<span class="result false">' +
                            '<i class="i_anw_false"></i><strong>' + kq + '</strong>'
                    '</span>';
                }
                $(this).append(html);
            });
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
    <script src="/assets/web/js/voice.js" type="text/javascript"></script>
@endsection