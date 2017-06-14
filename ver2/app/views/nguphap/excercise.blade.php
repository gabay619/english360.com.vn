@extends('layouts.detail')

@section('content')
    <?php $countTitle = 1 ?>
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/ngu-phap.html">Ngữ pháp</a></li>
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
                    @if($chontu)
                        <div class="question_label_8 block chontu baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$chontu->name}}</h4>
                            @if(!empty($chontu->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$chontu->ex}}</div>
                            @endif
                            @if(!empty($chontu->list))
                                <div class="list_tu_goi_y block">
                                    @foreach(explode('|',$chontu->list) as $aWord)
                                        <span>{{$aWord}}</span>
                                    @endforeach
                                </div>
                            @endif
                            @foreach($chontu->question as $key=>$aDientu)
                                <div class="item_ql6">
                                    <div style="display: inline-block">
                                        <p>
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}">
                                                <i class="fa fa-2x fa-volume-off fa-disable"></i>
                                            </a>
                                            <span class="sp_get_input">
                                                {{str_replace('_','<input class="input_2 w150" data-aw="'.$aDientu['word'].'" data-full="'.$aDientu['word'].'" type="text">',$aDientu['sentence'])}}
                                            </span>
                                            <i></i>
                                        </p>
                                    </div>
                                    <div style="margin-left: 45px">
                                        <p>
                                        <span class="dientu_dapan" style="display: none">
                                            {{str_replace('_','<span class="result">'.explode('|',$aDientu['word'])[0].'</span>',$aDientu['sentence'])}}
                                        </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkChontu()" id="btnCheckChontu">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComChontu">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsChontu">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwChontu">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>

                    @endif
                    @if($dientu)
                        <div class="question_label_8 block dientu baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$dientu->name}}</h4>
                            @if(!empty($dientu->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$dientu->ex}}</div>
                            @endif
                            @foreach($dientu->question as $key=>$aDientu)
                                <div class="item_ql6">
                                    <div style="display: inline-block">
                                        <p>
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}">
                                                <i class="fa fa-volume-off fa-2x fa-disable"></i>
                                            </a>
                                        <span class="sp_get_input">
                                            {{str_replace('_','<input class="input_2 w150" data-aw="'.$aDientu['word'].'" data-full="'.$aDientu['word'].'" type="text">',$aDientu['sentence'])}}
                                        </span>
                                            <i></i>
                                        </p>
                                    </div>
                                    <div style="margin-left: 45px">
                                        <p>
                                        <span class="dientu_dapan" style="display: none">
                                            {{str_replace('_','<span class="result">'.explode('|',$aDientu['word'])[0].'</span>',$aDientu['sentence'])}}
                                        </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkDientu()" id="btnCheckDientu">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComDientu">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsDientu">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwDientu">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($diencumtu)
                        <div class="question_label_8 block diencumtu baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$diencumtu->name}}</h4>
                            @if(!empty($diencumtu->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$diencumtu->ex}}</div>
                            @endif
                            @if(!empty($diencumtu->list))
                                <div class="list_tu_goi_y block">
                                    @foreach(explode('|',$diencumtu->list) as $aPhrase)
                                        <span>{{$aPhrase}}</span>
                                    @endforeach
                                </div>
                            @endif
                            @foreach($diencumtu->question as $key=>$aDientu)
                                <div class="item_ql6">
                                    <div style="display: inline-block">
                                        <p>
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                            <span class="sp_get_input">
                                                {{str_replace('_','<input class="input_2 w150" data-aw="'.$aDientu['phrase'].'" data-full="'.$aDientu['phrase'].'" type="text" placeholder="">',$aDientu['sentence'])}}
                                            </span>
                                            <i></i>
                                        </p>
                                    </div>
                                    <div style="margin-left: 45px">
                                        <p>
                                        <span class="dientu_dapan" style="display: none">
                                            {{str_replace('_','<span class="result">'.explode('|',$aDientu['phrase'])[0].'</span>',$aDientu['sentence'])}}
                                        </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkDiencumtu()" id="btnCheckDiencumtu">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComDiencumtu">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsDiencumtu">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwDiencumtu">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($diennhieutu)
                        <div class="question_label_8 block diennhieutu baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$diennhieutu->name}}</h4>
                            @if($diennhieutu->content)
                                <div class="question_label_8 block">
                                    <div class="doanvan">
                                        {{urldecode($diennhieutu->content)}}
                                    </div>
                                </div>
                            @endif
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkDiennhieutu()" id="btnCheckDiennhieutu">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComDiennhieutu">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsDiennhieutu">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwDiennhieutu">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($vietlaicau)
                        <div class="question_label_8 block vietlaicau baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$vietlaicau->name}}</h4>
                            @if(!empty($vietlaicau->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$vietlaicau->ex}}</div>
                            @endif
                            @if(!empty($vietlaicau->list))
                                <div class="list_tu_goi_y block">
                                    @foreach(explode('|',$vietlaicau->list) as $aPhrase)
                                        <span>{{$aPhrase}}</span>
                                    @endforeach
                                </div>
                            @endif
                            @foreach($vietlaicau->question as $key=>$aDientu)
                                <div class="item_ql6">
                                    <div>
                                        <p>
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                            <b>
                                                {{$aDientu['sentence']}}
                                            </b>
                                        </p>
                                        <?php $vietlaicauArr = explode(PHP_EOL,$aDientu['aw']); ?>
                                        @foreach($vietlaicauArr as $k=>$aw)
                                            <?php $awArr = explode('|',$aw);
                                            $audioArr = explode(PHP_EOL,$aDientu['awaudio']);
                                            $awAudio = isset($audioArr[$k]) ? $audioArr[$k] : '';
                                            ?>

                                            <p style="margin-top: 10px">@if(count($vietlaicauArr) > 1 ){{strtolower(Common::numtoalpha($k))}}.@endif
                                                @if($awAudio)
                                                <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$awAudio}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                                @endif
                                                @if($awArr[0])
                                                <span style="font-style: italic">{{$awArr[0]}}</span>
                                                @endif
                                                <?php unset($awArr[0]);
                                                $dataAw = implode('|',$awArr);
                                                ?>
                                                <span class="sp_get_input">
                                                <input type="text" class="input_2" style="width: 95%; text-align:left; border-bottom-style: dashed" data-aw="{{$dataAw}}">
                                            </span>
                                                <i></i>
                                            </p>

                                            {{--<p>--}}
                                            {{----}}
                                            {{--</p>--}}
                                            <p class="dientu_dapan" style="display: none;">
                                                <b>Đáp án: </b>{{explode('|',$dataAw)[0]}}
                                            </p>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkVietlaicau()" id="btnCheckVietlaicau">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComVietlaicau">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsVietlaicau">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwVietlaicau">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($dungsai)
                        <div class="question_label_8 block dungsai baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$dungsai->name}}</h4>
                            @if(!empty($dungsai->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$dungsai->ex}}</div>
                            @endif
                            @foreach($dungsai->question as $key=>$aDientu)
                                <div class="item_ql6">
                                    <div style="display: inline-block">
                                        <p class="get_sentence">
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                            <span class="sp_get_input">
                                                {{str_replace('_','<span class="has_sentence" style="text-decoration:underline" data-aw="'.$aDientu['aw'].'">'.$aDientu['fill'].'</span>',$aDientu['sentence'])}}
                                            </span>
                                        </p>
                                        <p>
                                            <span class="dientu_dapan" style="display: none">
                                                {{str_replace('_','<span class="result">'.explode('|',$aDientu['aw'])[0].'</span>',$aDientu['sentence'])}}
                                            </span>
                                        </p>
                                        <p class="get_radio">
                                            <label for="check_{{$key}}_1">
                                                <input id="check_{{$key}}_1" type="radio" value="1" name="check_ds_{{$key}}"> Đúng
                                            </label>
                                            <label for="check_{{$key}}_0" style="margin-left: 20px">
                                                <input id="check_{{$key}}_0" type="radio" value="0" name="check_ds_{{$key}}"> Sai
                                            </label>
                                            <input type="text" class="input_2" style="display: none">
                                            <i></i>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkDungsai()" id="btnCheckDungsai">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComDungsai">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsDungsai">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwDungsai">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($vietlaicautranh)
                        <div class="question_label_8 block vietlaicautranh baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$vietlaicautranh->name}}</h4>
                            @if(!empty($vietlaicautranh->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$vietlaicautranh->ex}}</div>
                            @endif
                            @foreach($vietlaicautranh->question as $key=>$aVlct)
                                <div class="item_ql6" style="text-align: center">
                                    <p style="margin-bottom: 10px">
                                        <b>{{$key+1}}. </b>
                                        <span class="a_goiy">
                                            <img src="{{$aVlct['pic']}}" alt="">
                                        </span>
                                        <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aVlct['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                    </p>
                                    <p>
                                        <span style="font-style: italic">({{$aVlct['suggest']}})</span>
                                    </p>
                                    <p>
                                        <span class="sp_get_input">
                                            <input type="text" class="input_2" style="width: 80%; text-align:center; border-bottom-style: dashed" data-aw="{{$aVlct['aw']}}">
                                        </span>
                                        <i></i>
                                    </p>
                                    <p class="dientu_dapan" style="display: none;">
                                        <b>Đáp án: </b>{{explode('|',$aVlct['aw'])[0]}}
                                    </p>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkVietlaicautranh()" id="btnCheckVietlaicautranh">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComVietlaicautranh">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsVietlaicautranh">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwVietlaicautranh">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($tracnghiem)
                        <div class="question_label_1 block tracnghiem baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$tracnghiem->name}}</h4>
                            @if(!empty($tracnghiem->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$tracnghiem->ex}}</div>
                            @endif
                            @foreach($tracnghiem->question as $key=>$aTn)
                                <div class="item_ql1 block" style="margin-top: 15px">
                                    <div style="display: inline-block">
                                        <p>
                                            <b>{{$key+1}}. </b>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aTn['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                            <span class="sp_get_input">
                                                {{str_replace('_','__________',$aTn['sentence'])}}
                                            </span>
                                        </p>
                                        <div class="list_anws_item_ql1 block tracnghiemAns" data-true="{{$aTn['aw']}}">
                                            @foreach(explode('|',$aTn['list']) as $k=>$aAns)
                                                <div class="item_anws_item_ql1 checkbox_css3" style="float: left; margin-right: 10px">
                                                    <input id="check_tn_{{$key}}_{{$k}}" type="checkbox" value="check{{$k}}">
                                                    <label for="check_tn_{{$key}}_{{$k}}">{{$aAns}}</label>
                                                </div>
                                            @endforeach
                                            <i></i>
                                        </div>
                                    </div>
                                    <p class="dientu_dapan" style="display: none;">
                                        <b>Đáp án: </b>{{str_replace('_','<span class="result">'.explode('|',$aTn['list'])[$aTn['aw']-1].'</span>',$aTn['sentence'])}}
                                    </p>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkTracnghiem()" id="btnCheckTracnghiem">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComTracnghiem">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsTracnghiem">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwTracnghiem">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($tracnghiemtranh)
                        <div class="question_label_1 block tracnghiemtranh baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$tracnghiemtranh->name}}</h4>
                            @if(!empty($tracnghiemtranh->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$tracnghiemtranh->ex}}</div>
                            @endif
                            @foreach($tracnghiemtranh->question as $key=>$aTn)
                                <div class="item_ql1 block" style="margin-top: 15px;text-align: center">
                                    <div style="display: inline-block">
                                        <p style="margin-bottom: 10px">
                                            <b>{{$key+1}}. </b>
                                            <span class="a_goiy">
                                                <img src="{{$aTn['pic']}}" alt="">
                                            </span>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aTn['audio']}}"><i class="fa fa-volume-off fa-2x fa-disable"></i></a>
                                        </p>
                                        <div class="list_anws_item_ql1 block tracnghiemAns" data-true="{{$aTn['aw']}}">
                                            @foreach(explode('|',$aTn['list']) as $k=>$aAns)
                                                <div class="item_anws_item_ql1 checkbox_css3" style="float: left; margin-right: 10px">
                                                    <input id="check_tnt_{{$key}}_{{$k}}" type="checkbox" value="check{{$k}}">
                                                    <label for="check_tnt_{{$key}}_{{$k}}">{{$aAns}}</label>
                                                </div>
                                            @endforeach
                                            <i></i>
                                        </div>
                                    </div>
                                    <p class="dientu_dapan" style="display: none;">
                                        <b>Đáp án: </b> @foreach(explode('|',$aTn['aw']) as $k=>$ans) {{explode('|',$aTn['list'])[$ans-1]}}@if($k+1!=sizeof(explode('|',$aTn['aw']))),@endif @endforeach
                                    </p>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkTracnghiemtranh()" id="btnCheckTracnghiemtranh">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComTracnghiemtranh">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsTracnghiemtranh">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwTracnghiemtranh">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($dientutranh)
                        <div class="question_label_8 block dientutranh baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$dientutranh->name}}</h4>
                            @if(!empty($dientutranh->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$dientutranh->ex}}</div>
                            @endif
                            @foreach($dientutranh->question as $key=>$aDientu)
                                <div class="item_ql6" style="margin-top: 15px">
                                    <div style="text-align: center">
                                        <p style="margin-bottom: 10px;">
                                            <b>{{$key+1}}. </b>
                                            <span class="a_goiy">
                                                <img src="{{$aDientu['pic']}}" alt="">
                                            </span><br>
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$aDientu['audio']}}">
                                                <i class="fa fa-volume-off fa-2x fa-disable"></i>
                                            </a>
                                        </p>
                                        <p style="margin-left:35px">
                                            <span class="sp_get_input">
                                                {{str_replace('_','<input class="input_2 w150" data-aw="'.$aDientu['aw'].'" data-full="'.$aDientu['aw'].'" type="text">',$aDientu['sentence'])}}
                                            </span>
                                            <i></i>
                                        </p>
                                        <p class="dientu_dapan" style="display: none; margin-left:15px">
                                            <b>Đáp án: </b> {{str_replace('_','<span class="result">'.explode('|',$aDientu['aw'])[0].'</span>',$aDientu['sentence'])}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkDientutranh()" id="btnCheckDientutranh">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComDientutranh">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsDientutranh">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwDientutranh">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                    @if($ghepcau)
                        <div class="question_label_8 block ghepcau baitap" style="display: none">
                            <h4 class="title_1" style="text-transform: initial; padding-top: 5px">{{Common::numberToRoman($countTitle++)}}. {{$ghepcau->name}}</h4>
                            @if(!empty($ghepcau->ex))
                                <div style="border: 1px dashed #ccc; padding: 5px; margin-bottom: 10px">{{$ghepcau->ex}}</div>
                            @endif

                            <div class="item_ql4 block">
                                <div class="data date_left">
                                    @foreach($ghepcau->aw as $key=>$anAns)
                                        <span>{{$key+1}}.
                                            <a class="dientuSpeaker" href="javascript:void(0)" data-audio="{{$ghepcau->audio[$key]}}">
                                                <i class="fa fa-volume-off fa-2x fa-disable"></i>
                                            </a>
                                            {{$anAns}}
                                        </span>
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
                                            <span class="result">
                                                <i></i>
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                                <div class="notice_1 notice_ql2 block dapan" style="display: none">
                                    @foreach($ghepcau->true as $key=>$val)
                                        <span>{{$key+1}}. {{$val}}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn_bottom_dentail_default center">
                                <a class="btn_x btn_blue btn_luubaihoc" href="javascript:checkGhepcau()" id="btnCheckGhepcau">Kiểm tra</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnComGhepcau">Hoàn thành</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRsGhepcau">Đáp án</a>
                                <a class="btn_x btn_blue btn_luubaihoc btn_disable" href="javascript:void(0)" id="btnRwGhepcau">Làm lại</a>
                                <a class="btn_x btn_blue btn_luubaihoc baitiep" href="javascript:toNext()">Bài tiếp</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .btn_disable, .btn_disable:hover, .btn_disable:active, .btn_disable:focus{
            background: #999;
        }
        .block p {
            margin: 0;
            line-height: 1.8;
        }
        .block a {
            display: inline-block;
        }
        .fa-disable, .fa-disable:hover, .fa-disable:active, .fa-disable:focus{
            color: #999;
            cursor: default;
        }
    </style>
    <script>
        $('.Loa').each(function(){
            var src = $(this).attr('alt');
//                html = '<a href="javascript:playAudio(\''+src+'\')"><i class="fa fa-fw"></i></a>';
            html = '<a class="dientuSpeaker" href="javascript:void(0)" data-audio="'+src+'">'+
                    '<i class="fa fa-volume-off fa-2x fa-disable"></i>'+
                    '</a>';
            $(this).after(html);
            $(this).remove();
        });
        var baitapIndex = 0;

        function toNext(){
            baitapIndex++;
            $('.baitap').hide();
            $('.baitap').eq(baitapIndex).fadeIn();
            if(!$('.baitap').eq(parseInt(baitapIndex)+1).length){
                $('.baitap').eq(baitapIndex).find('.baitiep').attr('href','javascript:toBegin()').html('Làm lại tất cả');
            }
            $('html,body').scrollTop(0);
        }

        function toBegin(){
            location.reload();
        }
        $(function(){
            $('.tracnghiem .item_anws_item_ql1 input').change(function(){
                $(this).parent().parent().find('input').not($(this)).prop('checked', false);
            });

            $('.baitap').eq(baitapIndex).show();

            $('.get_radio input[type=radio]').on('change', function(){
                if($(this).val() == 0){
                    $(this).parent().parent().find('input[type=text]').show().focus();
                }else{
                    $(this).parent().parent().find('input[type=text]').hide();
                }
            })

            $('.diennhieutu img.InputQuestion').each(function () {
                var kq = $(this).attr('alt');
                $(this).after('<span><input class="input_2 w150" data-aw="' + kq + '" data-full="' + kq + '" type="text"><i></i></span>');
                $(this).hide();
            })
            $('.baitap .input_2').keyup(function(){
                textWidth = $(this).val().length * 7;
                if(textWidth > $(this).width()){
                    $(this).width(textWidth)
                }
                console.log(textWidth)
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

        function checkPhrase(ph1,ph2){
            return ph1.toLowerCase().replace(/[^a-zA-Z]/g, "") == ph2.toLowerCase().replace(/[^a-zA-Z]/g, "");
        }

        function removeAllSpecialCharacters(str) {
            return str.replace(/[^a-zA-Z]/g, "");
        }

        //Điền từ
        function checkDientu() {
            $('.dientu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }

//                ans = $(this).val().toLowerCase();
//                trueans = $(this).attr('data-aw');
//                trueansArr = trueans.split('|');
//                if($.inArray(ans,trueansArr)>=0){
//                    iclass = 'i_anw_true';
//                }else{
//                    iclass = 'i_anw_false';
//                }
                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComDientu').removeClass('btn_disable').attr('href', 'javascript:completeDientu()');
        }

        function completeDientu() {
            $('.dientu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }

            })
            $('.dientu .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.dientu .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckDientu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComDientu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsDientu').removeClass('btn_disable').attr('href', 'javascript:resultDientu()');
        }

        function resultDientu() {
            $('.dientu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }

            })
            $('.dientu .dientu_dapan').fadeIn();
            $('#btnRsDientu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwDientu').removeClass('btn_disable').attr('href', 'javascript:reworkDientu()');
        }

        function reworkDientu() {
            $('.dientu .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.dientu .dientuSpeaker').attr('href','javascript:void(0)');
            $('.dientu .dientu_dapan').hide();
            $('.dientu .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input class="input_2 w150" data-aw="'+aw+'" data-full="'+aw+'" type="text">';
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwDientu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckDientu').removeClass('btn_disable').attr('href', 'javascript:checkDientu()');
        }

        //Chọn từ
        function checkChontu() {
            $('.chontu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }

                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComChontu').removeClass('btn_disable').attr('href', 'javascript:completeChontu()');
        }

        function completeChontu() {
            $('.chontu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }


            })
            $('.chontu .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.chontu .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckChontu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComChontu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsChontu').removeClass('btn_disable').attr('href', 'javascript:resultChontu()');
        }

        function resultChontu() {
            $('.chontu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }

            })
            $('.chontu .dientu_dapan').fadeIn();
            $('#btnRsChontu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwChontu').removeClass('btn_disable').attr('href', 'javascript:reworkChontu()');
        }

        function reworkChontu() {
            $('.chontu .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.chontu .dientuSpeaker').attr('href','javascript:void(0)');
            $('.chontu .dientu_dapan').hide();
            $('.chontu .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input class="input_2 w150" data-aw="'+aw+'" data-full="'+aw+'" type="text">';
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwChontu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckChontu').removeClass('btn_disable').attr('href', 'javascript:checkChontu()');
        }

        //Điền cụm từ
        function checkDiencumtu() {
            $('.diencumtu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }
                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComDiencumtu').removeClass('btn_disable').attr('href', 'javascript:completeDiencumtu()');
        }

        function completeDiencumtu() {
            $('.diencumtu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }
            })
            $('.diencumtu .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.diencumtu .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckDiencumtu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComDiencumtu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsDiencumtu').removeClass('btn_disable').attr('href', 'javascript:resultDiencumtu()');
        }

        function resultDiencumtu() {
            $('.diencumtu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }
            })
            $('.diencumtu .dientu_dapan').fadeIn();
            $('#btnRsDiencumtu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwDiencumtu').removeClass('btn_disable').attr('href', 'javascript:reworkDiencumtu()');
        }

        function reworkDiencumtu() {
            $('.diencumtu .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.diencumtu .dientuSpeaker').attr('href','javascript:void(0)');
            $('.diencumtu .dientu_dapan').hide();
            $('.diencumtu .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input class="input_2 w150" data-aw="'+aw+'" data-full="'+aw+'" type="text" placeholder="">';
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwDiencumtu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckDiencumtu').removeClass('btn_disable').attr('href', 'javascript:checkDiencumtu()');
        }

        //Điền nhiều từ
        function checkDiennhieutu() {
            $('.diennhieutu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                console.log(trueansArr)
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }
                $(this).parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComDiennhieutu').removeClass('btn_disable').attr('href', 'javascript:completeDiennhieutu()');
        }

        function completeDiennhieutu() {
            $('.diennhieutu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().find('>i').removeClass().addClass(iclass);
                }
            })
            $('.diennhieutu .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.diennhieutu .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckDiennhieutu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComDiennhieutu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsDiennhieutu').removeClass('btn_disable').attr('href', 'javascript:resultDiennhieutu()');
        }

        function resultDiennhieutu() {
            $('.diennhieutu input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>'+
                            '<span class="result true" data-aw="'+trueans+'">'+
                            trueansArr[0]+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }
            })
//            $('.diencumtu .dientu_dapan').fadeIn();
            $('#btnRsDiennhieutu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwDiennhieutu').removeClass('btn_disable').attr('href', 'javascript:reworkDiennhieutu()');
        }

        function reworkDiennhieutu() {
            $('.diennhieutu .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.diennhieutu .dientuSpeaker').attr('href','javascript:void(0)');
//            $('.diennhieutu .dientu_dapan').hide();
            $('.diennhieutu span.result.true').each(function(){
                $(this).parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input class="input_2 w150" data-aw="'+aw+'" data-full="'+aw+'" type="text" placeholder="">';
                $(this).after(html);
//                $(this).remove();
            });
            $('.diennhieutu span.result').remove();
            $('#btnRwDiennhieutu').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckDiennhieutu').removeClass('btn_disable').attr('href', 'javascript:checkDiennhieutu()');
        }

        //Viết lại câu
        function checkVietlaicau() {
            $('.vietlaicau input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }
                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComVietlaicau').removeClass('btn_disable').attr('href', 'javascript:completeVietlaicau()');
        }

        function completeVietlaicau() {
            $('.vietlaicau input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }
            })
            $('.vietlaicau .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.vietlaicau .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckVietlaicau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComVietlaicau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsVietlaicau').removeClass('btn_disable').attr('href', 'javascript:resultVietlaicau()');
        }

        function resultVietlaicau() {
            $('.vietlaicau input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }
            })
            $('.vietlaicau .dientu_dapan').fadeIn();
            $('#btnRsVietlaicau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwVietlaicau').removeClass('btn_disable').attr('href', 'javascript:reworkVietlaicau()');
        }

        function reworkVietlaicau() {
            $('.vietlaicau .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.vietlaicau .dientuSpeaker').attr('href','javascript:void(0)');
            $('.vietlaicau .dientu_dapan').hide();
            $('.vietlaicau .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input type="text" class="input_2" style="width: 95%; text-align:left; border-bottom-style: dashed" data-aw="'+aw+'">'
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwVietlaicau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckVietlaicau').removeClass('btn_disable').attr('href', 'javascript:checkVietlaicau()');
        }

        //Đúng sai
        function checkDungsai() {
            $('.dungsai .item_ql6').each(function(){
                sentence = $(this).find('.has_sentence');
                aw = false;
                trueans = sentence.attr('data-aw');
                trueansArr = trueans.split('|');
                ans = sentence.html();
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        aw = true;
                    }
                }

                rs = false;
                if($(this).find('input[type=radio]:checked').length){
                    val  = $(this).find('input[type=radio]:checked').val();
                    if(val == 1){
                        if(aw) rs = true;
                    }else{
                        if(!aw){
                            input_ans = $(this).find('input[type=text]').val();
                            for(i=0;i<trueansArr.length;i++){
                                if(checkPhrase(input_ans,trueansArr[i])){
                                    rs = true;
                                }
                            }
                        }
                    }
                }
                iclass = 'i_anw_false';
                if(rs) iclass = 'i_anw_true';
                $(this).find('p.get_radio>i').removeClass().addClass(iclass);
            })

            $('#btnComDungsai').removeClass('btn_disable').attr('href', 'javascript:completeDungsai()');
        }

        function completeDungsai() {
            $('.dungsai .item_ql6').each(function(){
                sentence = $(this).find('.has_sentence');
                aw = false;
                trueans = sentence.attr('data-aw');
                trueansArr = trueans.split('|');
                ans = sentence.html();
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        aw = true;
                    }
                }

                rs = false;
                if($(this).find('input[type=radio]:checked').length){
                    val  = $(this).find('input[type=radio]:checked').val();
                    if(val == 1){
                        if(aw) rs = true;
                    }else{
                        if(!aw){
                            input_ans = $(this).find('input[type=text]').val();
                            for(i=0;i<trueansArr.length;i++){
                                if(checkPhrase(input_ans,trueansArr[i])){
                                    rs = true;
                                    html = '<span class="result true" data-aw="'+trueans+'">'+
                                            input_ans + '</span>';
                                    $(this).find('input[type=text]').after(html);
                                    $(this).find('input[type=text]').remove();
                                }
                            }
                        }
                    }
                }
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                    $(this).find('input').prop('disabled',true);
                }
                $(this).find('p.get_radio>i').removeClass().addClass(iclass);
            })

            $('.dungsai .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.dungsai .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckDungsai').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComDungsai').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsDungsai').removeClass('btn_disable').attr('href', 'javascript:resultDungsai()');
        }

        function resultDungsai() {
            $('.dungsai .item_ql6').each(function(){
                sentence = $(this).find('.has_sentence');
                aw = false;
                trueans = sentence.attr('data-aw');
                trueansArr = trueans.split('|');
                ans = sentence.html();
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        aw = true;
                    }
                }

                rs = false;
                if($(this).find('input[type=radio]:checked').length){
                    val  = $(this).find('input[type=radio]:checked').val();
                    if(val == 1){
                        if(aw) rs = true;
                    }else{
                        if(!$(this).find('input[type=radio]').prop('disabled')){
                            input_ans = $(this).find('input[type=text]').val();
                            if(!aw){
                                for(i=0;i<trueansArr.length;i++){
                                    if(checkPhrase(input_ans,trueansArr[i])){
                                        rs = true;
                                        html = '<span class="result true" data-aw="'+trueans+'">'+
                                                input_ans + '</span>';
                                        $(this).find('input[type=text]').after(html);
                                        $(this).find('input[type=text]').remove();
                                    }
                                }
                            }
                            if(!rs){
                                html = '<span class="result false" data-aw="'+trueans+'">'+
                                        input_ans+ '</span>';
                                $(this).find('input[type=text]').after(html);
                                $(this).find('input[type=text]').remove();
                            }
                        }else{
                            rs = true;
                        }
                    }
                }
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                }
                $(this).find('input').prop('disabled',true);
                $(this).find('p.get_radio>i').removeClass().addClass(iclass);
            })

            $('.dungsai .dientu_dapan').fadeIn();
            $('#btnRsDungsai').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwDungsai').removeClass('btn_disable').attr('href', 'javascript:reworkDungsai()');
        }

        function reworkDungsai() {
            $('.dungsai .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.dungsai .dientuSpeaker').attr('href','javascript:void(0)');
            $('.dungsai .dientu_dapan').hide();
            $('.dungsai .get_radio span.result').after('<input type="text" class="input_2" style="display: none">').remove();
            $('.dungsai .get_radio>i').removeClass();
            $('.dungsai input').prop('disabled', false).prop('checked',false);

            $('#btnRwDungsai').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckDungsai').removeClass('btn_disable').attr('href', 'javascript:checkDungsai()');
        }

        //Viết lại câu theo tranh
        function checkVietlaicautranh() {
            $('.vietlaicautranh input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                iclass = 'i_anw_false';
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        iclass = 'i_anw_true';
                    }
                }
                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })
            $('#btnComVietlaicautranh').removeClass('btn_disable').attr('href', 'javascript:completeVietlaicautranh()');
        }

        function completeVietlaicautranh() {
            $('.vietlaicautranh input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    iclass = 'i_anw_true';
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans + '</span>';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }
            })
            $('.vietlaicautranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.vietlaicautranh .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckVietlaicautranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComVietlaicautranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsVietlaicautranh').removeClass('btn_disable').attr('href', 'javascript:resultVietlaicautranh()');
        }

        function resultVietlaicautranh() {
            $('.vietlaicautranh input').each(function(){
                ans = $(this).val();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }

                if(rs){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }
            })
            $('.vietlaicautranh .dientu_dapan').fadeIn();
            $('#btnRsVietlaicautranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwVietlaicautranh').removeClass('btn_disable').attr('href', 'javascript:reworkVietlaicautranh()');
        }

        function reworkVietlaicautranh() {
            $('.vietlaicautranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.vietlaicautranh .dientuSpeaker').attr('href','javascript:void(0)');
            $('.vietlaicautranh .dientu_dapan').hide();
            $('.vietlaicautranh .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input type="text" class="input_2" style="width: 95%; text-align:left; border-bottom-style: dashed" data-aw="'+aw+'">'
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwVietlaicautranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckVietlaicautranh').removeClass('btn_disable').attr('href', 'javascript:checkVietlaicautranh()');
        }

        //Trắc nghiệm
        function checkTracnghiem() {
            $('.tracnghiem .item_ql1').each(function(){
                rs = false;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    if($(this).find('input').is(':checked') && index==trueans){
                        rs = true;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                }
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })

            $('#btnComTracnghiem').removeClass('btn_disable').attr('href', 'javascript:completeTracnghiem()');
        }

        function completeTracnghiem() {
            $('.tracnghiem .item_ql1').each(function(){
                rs = false;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    if($(this).find('input').is(':checked') && index==trueans){
                        rs = true;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    $(this).find('input').prop('disabled',true);
                    iclass = 'i_anw_true';
                }
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })
            $('.tracnghiem .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.tracnghiem .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckTracnghiem').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComTracnghiem').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsTracnghiem').removeClass('btn_disable').attr('href', 'javascript:resultTracnghiem()');
        }

        function resultTracnghiem() {
            $('.tracnghiem .item_ql1').each(function(){
                rs = false;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    if($(this).find('input').is(':checked') && index==trueans){
                        rs = true;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                }
                $(this).find('input').prop('disabled',true);
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })
            $('.tracnghiem .dientu_dapan').fadeIn();
            $('#btnRsTracnghiem').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwTracnghiem').removeClass('btn_disable').attr('href', 'javascript:reworkTracnghiem()');
        }

        function reworkTracnghiem() {
            $('.tracnghiem .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.tracnghiem .dientuSpeaker').attr('href','javascript:void(0)');
            $('.tracnghiem .dientu_dapan').hide();
            $('.tracnghiem input').prop('disabled',false);
            $('.tracnghiem input').prop('checked',false);
            $('.tracnghiem .tracnghiemAns i').removeClass();
            $('#btnRwTracnghiem').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckTracnghiem').removeClass('btn_disable').attr('href', 'javascript:checkTracnghiem()');
        }

        //Trắc nghiệm tranh
        function checkTracnghiemtranh() {
            $('.tracnghiemtranh .item_ql1').each(function(){
                rs = true;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                trueansArr = trueans.split('|');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    index = index.toString();
                    if($(this).find('input').is(':checked') && $.inArray(index, trueansArr)<0){
                        rs = false;
                    }
                    if(!$(this).find('input').is(':checked') && $.inArray(index, trueansArr)>=0){
                        rs = false;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                }
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })
            $('#btnComTracnghiemtranh').removeClass('btn_disable').attr('href', 'javascript:completeTracnghiemtranh()');
        }

        function completeTracnghiemtranh() {
            $('.tracnghiemtranh .item_ql1').each(function(){
                rs = true;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                trueansArr = trueans.split('|');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    index = index.toString();
                    if($(this).find('input').is(':checked') && $.inArray(index, trueansArr)<0){
                        rs = false;
                    }
                    if(!$(this).find('input').is(':checked') && $.inArray(index, trueansArr)>=0){
                        rs = false;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    $(this).find('input').prop('disabled',true);
                    iclass = 'i_anw_true';
                }
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })
            $('.tracnghiemtranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.tracnghiemtranh .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckTracnghiemtranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComTracnghiemtranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsTracnghiemtranh').removeClass('btn_disable').attr('href', 'javascript:resultTracnghiemtranh()');
        }

        function resultTracnghiemtranh() {
            $('.tracnghiemtranh .item_ql1').each(function(){
                rs = true;
                trueans = $(this).find('.tracnghiemAns').attr('data-true');
                trueansArr = trueans.split('|');
                $(this).find('.item_anws_item_ql1').each(function(e){
                    index = parseInt(e)+1;
                    index = index.toString();
                    if($(this).find('input').is(':checked') && $.inArray(index, trueansArr)<0){
                        rs = false;
                    }
                    if(!$(this).find('input').is(':checked') && $.inArray(index, trueansArr)>=0){
                        rs = false;
                    }
                })
                iclass = 'i_anw_false';
                if(rs){
                    iclass = 'i_anw_true';
                }
                $(this).find('input').prop('disabled',true);
                $(this).find('.tracnghiemAns i').removeClass().addClass(iclass);
            })
            $('.tracnghiemtranh .dientu_dapan').fadeIn();
            $('#btnRsTracnghiemtranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwTracnghiemtranh').removeClass('btn_disable').attr('href', 'javascript:reworkTracnghiemtranh()');
        }

        function reworkTracnghiemtranh() {
            $('.tracnghiemtranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.tracnghiemtranh .dientuSpeaker').attr('href','javascript:void(0)');
            $('.tracnghiemtranh .dientu_dapan').hide();
            $('.tracnghiemtranh input').prop('disabled',false);
            $('.tracnghiemtranh input').prop('checked',false);
            $('.tracnghiemtranh .tracnghiemAns i').removeClass();
            $('#btnRwTracnghiemtranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckTracnghiemtranh').removeClass('btn_disable').attr('href', 'javascript:checkTracnghiemtranh()');
        }

        //Điền từ theo tranh
        function checkDientutranh() {
            $('.dientutranh input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                if($.inArray(ans,trueansArr)>=0){
                    iclass = 'i_anw_true';
                }else{
                    iclass = 'i_anw_false';
                }
                $(this).parent().parent().find('>i').removeClass().addClass(iclass);
            })

            $('#btnComDientutranh').removeClass('btn_disable').attr('href', 'javascript:completeDientutranh()');
        }

        function completeDientutranh() {
            $('.dientutranh input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                if($.inArray(ans,trueansArr)>=0){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    iclass = 'i_anw_false';
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                }
            })
            $('.dientutranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.dientutranh .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckDientutranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComDientutranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsDientutranh').removeClass('btn_disable').attr('href', 'javascript:resultDientutranh()');
        }

        function resultDientutranh() {
            $('.dientutranh input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                if($.inArray(ans,trueansArr)>=0){
                    html = '<span class="result true" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_true';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }else{
                    html = '<span class="result false" data-aw="'+trueans+'">'+
                            ans+ '</span>';
                    iclass = 'i_anw_false';
                    $(this).after(html);
                    $(this).parent().parent().find('>i').removeClass().addClass(iclass);
                    $(this).remove();
                }
            })
            $('.dientutranh .dientu_dapan').fadeIn();
            $('#btnRsDientutranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwDientutranh').removeClass('btn_disable').attr('href', 'javascript:reworkDientutranh()');
        }

        function reworkDientutranh() {
            $('.dientutranh .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.dientutranh .dientuSpeaker').attr('href','javascript:void(0)');
            $('.dientutranh .dientu_dapan').hide();
            $('.dientutranh .sp_get_input span.result').each(function(){
                $(this).parent().parent().find('>i').removeClass();
                aw = $(this).attr('data-aw')
                html = '<input class="input_2 w150" data-aw="'+aw+'" data-full="'+aw+'" type="text">';
                $(this).after(html);
                $(this).remove();
            });
            $('#btnRwDientutranh').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckDientutranh').removeClass('btn_disable').attr('href', 'javascript:checkDientutranh()');
        }

        //Ghép câu
        function checkGhepcau() {
            $('.ghepcau input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-answer').toLowerCase();
                if(ans == trueans){
                    iclass = 'i_anw_true';
                }else{
                    iclass = 'i_anw_false';
                }
                $(this).parent().find('i').removeClass().addClass(iclass);
            })
            $('#btnComGhepcau').removeClass('btn_disable').attr('href', 'javascript:completeGhepcau()');
        }

        function completeGhepcau() {
            $('.ghepcau input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-answer').toLowerCase();
                if(ans == trueans){
                    iclass = 'i_anw_true';
                    $(this).prop('disabled',true);
                }else{
                    iclass = 'i_anw_false';
                }
                $(this).parent().find('i').removeClass().addClass(iclass);
            })
            $('.ghepcau .dientuSpeaker i').removeClass().addClass('fa fa-volume-up fa-2x');
            $('.ghepcau .dientuSpeaker').each(function(){
                audio = $(this).attr('data-audio');
                href = 'javascript:playAudio(\''+audio+'\')';
                $(this).attr('href',href);
            })
            $('#btnCheckGhepcau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnComGhepcau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRsGhepcau').removeClass('btn_disable').attr('href', 'javascript:resultGhepcau()');
        }

        function resultGhepcau() {
            $('.ghepcau input').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-answer').toLowerCase();
                if(ans == trueans){
                    iclass = 'i_anw_true';
                }else{
                    iclass = 'i_anw_false';
                }
                $(this).prop('disabled',true);
                $(this).parent().find('i').removeClass().addClass(iclass);
            })
            $('.ghepcau .dapan').fadeIn();
            $('#btnRsGhepcau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnRwGhepcau').removeClass('btn_disable').attr('href', 'javascript:reworkGhepcau()');
        }

        function reworkGhepcau() {
            $('.ghepcau .dientuSpeaker i').removeClass().addClass('fa fa-volume-off fa-2x fa-disable');
            $('.ghepcau .dientuSpeaker').attr('href','javascript:void(0)');
            $('.ghepcau .dapan').hide();
            $('.ghepcau input').each(function(){
                $(this).parent().find('i').removeClass();
                $(this).prop('disabled',false);
                $(this).val('');
            });
            $('#btnRwGhepcau').addClass('btn_disable').attr('href', 'javascript:void(0)');
            $('#btnCheckGhepcau').removeClass('btn_disable').attr('href', 'javascript:checkGhepcau()');
        }

    </script>
@endsection