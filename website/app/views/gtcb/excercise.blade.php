@extends('layouts.detail')

@section('content')
    <?php $countTitle = 1 ?>
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/giao-tiep-co-ban.html">Giao tiếp cơ bản</a></li>
                        <li><a href="">Luyện tập</a></li>
                    </ul>
                </div>
                <div class="detail_gtcb_lt block">
                    <h2 class="heading4 heading_detail">
                        Luyện tập {{$post->name}}
                    </h2>
                </div>
                <div class="row behind_heading4">
                    <div class="left">
                        <label class="mini_date">{{date('d/m/Y', $post->datecreate)}}</label>
                    </div>
                    <div class="right">
                    </div>
                </div>
                @if(count($tracnghiem) > 0)
                <div class="question_label_1 block">
                    <h4 class="title_1">{{Common::numberToRoman($countTitle++)}}. Chọn câu trả lời đúng cho mỗi tình huống</h4>
                    <?php $count = 1;?>
                    @foreach($tracnghiem as $aTracnghiem)
                    <div class="item_ql1 block">
                        <strong class="block">
                            {{$count++}}. {{$aTracnghiem->name}}
                        </strong>
                        <div class="list_anws_item_ql1 block tracnghiemAns" data-true="{{$aTracnghiem->trueaw}}">
                            @foreach($aTracnghiem->aw as $key=>$anAns)
                            <div class="item_anws_item_ql1 checkbox_css3 block">
                                <input id="{{$aTracnghiem->_id}}_check_{{$key}}" type="checkbox" name="check" value="check{{$key}}" />
                                <label for="{{$aTracnghiem->_id}}_check_{{$key}}">{{$anAns}}</label>
                            </div>
                            @endforeach
                            {{--<div class="item_anws_item_ql1 checkbox_css3 block">--}}
                                {{--<input id="check2" type="checkbox" name="check" value="check1">--}}
                                {{--<label for="check2" class="lb_anw_false">Checkbox No. 2</label>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($sapxep)
                <div class="question_label_2 block">
                    <h4 class="title_1">{{Common::numberToRoman($countTitle++)}}. {{$sapxep->name}}</h4>
                    <?php $count = 'A';?>
                    <div class="item_ql2 block">
                        <div class="data block" id="sapxepThread">
                            @foreach(CommonHelpers::shuffle_assoc($sapxep->aw) as $key=>$anAns)
                            <span data-answer="{{$count}}" data-id="{{$key+1}}">{{$count++}}. {{$anAns}}</span>
                            @endforeach
                        </div>
                        <div class="list_anws_item_ql2 block" id="sapxepAns">
                            @for($i=1; $i<=count($sapxep->aw); $i++)
                            <div class="item_anws_item_ql2" style="display: inline-block">
                                <span>{{$i}}.</span>
                                <input type="text" class="input_2 w50" maxlength="1" data-id="{{$i}}"/>
                            </div>
                            @endfor
                        </div>
                        <div class="notice_1 notice_ql2 block" id="sapxepResult" style="display: none">
                        </div>
                    </div>
                </div>
                @endif
                @if($dientu)
                <div class="question_label_3 block">
                    <h4 class="title_1">{{Common::numberToRoman($countTitle++)}}. {{$dientu->name}}</h4>
                    <div class="item_ql3 block dientu" id="dientuContent">
                        {{$dientu->contents}}
                    </div>
                </div>
                @endif
                @if($ghepcau)
                <div class="question_label_4 block">
                    <h4 class="title_1">{{Common::numberToRoman($countTitle++)}}. {{$ghepcau->name}}</h4>
                    <div class="item_ql4 block">
                        <div class="data date_left">
                            @foreach($ghepcau->aw as $key=>$anAns)
                            <span>{{$key+1}}. {{$anAns}}</span>
                            @endforeach
                        </div>
                        <?php $count = 'A' ?>
                        <div class="data date_right">
                            @foreach($ghepcau->ax as $key=>$anAns)
                            <span>{{$count++}}. {{$anAns}}</span>
                            @endforeach
                        </div>
                        <div class="list_anws_item_ql2 block" id="ghepcauAns">
                            @for($i=0; $i<count($ghepcau->true); $i++)
                            <div class="item_anws_item_ql2" style="display: inline-block">
                                <span>{{$i+1}}.</span>
                                <input type="text" class="input_2 w50" maxlength="1" data-answer="{{$ghepcau->true[$i]}}" />
                            </div>
                            @endfor
                        </div>
                        <div class="notice_1 notice_ql2 block" style="display: none" id="ghepcauResult">
                            @foreach($ghepcau->true as $key=>$val)
                                <span>{{$key+1}}. {{$val}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if($luyennghe)
                <div class="question_label_5 block">
                    <h4 class="title_1">{{Common::numberToRoman($countTitle++)}}. {{$luyennghe->name}}</h4>
                    <div class="audio_player_area block center mgb20 mgt10">
                        <div class="audio-player">
                            <audio id="audio-player" src="{{$luyennghe->medialink}}" type="audio/mp3" controls></audio>
                        </div><!-- @end .audio-player -->

                    </div>
                    <div class="item_ql5 block">
                        <div class="ct_ql5 block">
                            {{$luyennghe->contents}}
                        </div>
                    </div>
                </div>
                @endif
                <div class="btn_bottom_dentail_default center">
                    <a class="btn_x btn_blue btn_luubaihoc" href="javascript:complete()" id="btnComplete">Hoàn thành</a>
                    <a class="btn_x btn_red btn_luubaihoc" href="{{$post->getDetailUrl()}}" id="btnContinue" style="display: none">Quay lại bài học</a>
                    <h2 id="textComplete" style="display: none; margin-top: 10px"></h2>
                </div>
            </div>
        </div>
    </div>
    <style>
        .dientu input.dt {
            border-bottom: 1px dotted #Fa9600!important;
            padding: 5px;
            border: medium none;
            /*font-weight: bold;*/
        }
        .dientu  .stt {
            background-color: #FA9600;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            padding: 5px;
            color: #fff;
            font-weight: bold;
            height: 25px;
            width: 25px;
            display: inline-block;
            text-align: center;
            line-height: 15px;
        }
        .dientu table{
            border: 1px solid #ccc;
            border-collapse: collapse;
            width: 100% !important;
        }
        .dientu table td{
            border: 1px solid #ccc;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
        }
        .dientu table td p{
            margin: 0;
        }
    </style>
    <script>
        var diem = 0;
        var tong = 0;
        $(function(){
            $('.item_anws_item_ql1 input').change(function(){
                $(this).parent().parent().find('input').not($(this)).prop('checked', false);
            });

            var a = $('.dientu img.InputQuestion');
            $.each(a, function (i) {
                var kq = $(this).attr('alt');
                $(this).before('<span class="stt">' + (i + 1) + '</span>');
                $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
                $(this).hide();
            })
        });

        function complete(){
//            if(!validateTracNghiem()){
//                alert('Bạn chưa hoàn thành bài tập Trắc nghiệm.'); return false;
//            }
//            if(!validateSapXep()){
//                alert('Bạn chưa hoàn thành bài tập Sắp xếp.'); return false;
//            }
//            if(!validateDienTu()){
//                alert('Bạn chưa hoàn thành bài tập Điền từ.'); return false;
//            }
            tracnghiemResult();
            sapxepResult();
            ghepcauResult();
            dientuResult();
            $('#btnComplete').remove();
            $('#btnContinue').show();
            $('#textComplete').show().html('Điểm của bạn là: '+diem+'/'+tong)
            console.log(diem+'/'+tong)
        }

        function validateTracNghiem(){
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

        function validateSapXep(){
            result = true;
            $('#sapxepAns input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });

            return result;
        }

        function validateDienTu(){
            result = true;
            $('#dientuContent input').each(function(){
                if($(this).val() == ''){
                    result = false;
                }
            });
            return result;
        }

        function sapxepResult(){
            //Hiện đáp án sắp xếp
            for(i=1; i <= {{count($sapxep->aw)}}; i++){
                ans = $('#sapxepThread span[data-id='+i+']').attr('data-answer');
//                console.log(i+'-'+ans);
                html = '<span>'+i+'. '+ans+'</span>';
                $('#sapxepResult').append(html);
            }
            $('#sapxepResult').show();

            $('#sapxepAns input').each(function(){
               id = $(this).attr('data-id');
                trueans = $('#sapxepThread span[data-id='+id+']').attr('data-answer').toLowerCase();
                ans = $(this).val().toLowerCase();
                tong++;

                if(trueans == ans){
                    html = '<span class="result">'+
                            '<i class="i_anw_true"></i>'+
                            '</span>';
                    diem++;

                }else{
                    html = '<span class="result">'+
                            '<i class="i_anw_false"></i>'+
                            '</span>';
                }
                $(this).after(html);
                $(this).prop('disabled', true);
            });
        }

        function tracnghiemResult(){
            $('.tracnghiemAns').each(function(){
               trueans = $(this).attr('data-true');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    tong++;
                    if(index == trueans){
                        $(this).find('label').addClass('lb_anw_true');
                        if($(this).find('input').is(':checked'))
                            diem++;
                    }else if($(this).find('input').is(':checked') && index != trueans){
                        $(this).find('label').addClass('lb_anw_false');
                    }
                    $(this).find('input').prop('disabled',true);
                });
            });
        }

        function ghepcauResult(){
            $('#ghepcauResult').show();
            $('#ghepcauAns input').each(function(){
                tong++;

                if($(this).attr('data-answer').toLowerCase() == $(this).val().toLowerCase()){
                    html = '<span class="result">'+
                            '<i class="i_anw_true"></i>'+
                            '</span>';
                    diem++;

                }else{
                    html = '<span class="result">'+
                            '<i class="i_anw_false"></i>'+
                            '</span>';
                }
                $(this).after(html);
                $(this).prop('disabled', true);
            });
        }

        function dientuResult(){
            $('input.tocheck').each(function(){
                tong++;

                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                if(ans == trueans){
                    html = '<span class="result true">'+
                            '<i class="i_anw_true"></i>'+ trueans+
                            '</span>';
                    diem++;


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