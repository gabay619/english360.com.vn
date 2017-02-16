@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="w1170">
            <div class="content_left pd_20">
                <div class="block block_dict">
                    <div class="breadcrum block">
                        <ul class="ul_breadcrum">
                            <li><a href="">Trang chủ</a></li>
                            <li><a href="">Từ điển</a></li>
                        </ul>
                    </div>
                    <div class="block search_dict">
                        <div class="block search_dict_alphabet">
                        <a href="/tu-dien.html?letter=&searchWord={{Input::get('searchWord')}}&cate={{Input::get('cate', '')}}" @if($letter == '') class="active" @endif>...</a>
                            @for($i=0; $i <= 25; $i++)
                                <a href="/tu-dien.html?letter={{strtoupper(Common::numtoalpha($i))}}&searchWord={{Input::get('searchWord')}}&cate={{Input::get('cate', '')}}" @if(strtoupper($letter) == strtoupper(Common::numtoalpha($i))) class="active" @endif>{{Common::numtoalpha($i)}}</a>
                            @endfor

                        </div>
                        <div class="block search_dict_input">
                            <input type="text" placeholder="Từ khóa cần tra..." id="txtSearchWord" value="{{Input::get('searchWord')}}"/>
                            <a href="javascript:searchWord()" class="btn_x btn_blue btn_luubaihoc mgt10 mgl10 mgb10 btn_search_dict">Tra từ</a>
                        </div>
                    </div>
                    <div class="content_dict">
                        <h2 class="heading_dict block">{{$letter}}</h2>
                        <table class="table_dict_list block">
                            @foreach($allTudien as $aWord)
                            <tr>
                                <td>
                                    <a class="item_dict" href="javascript:void(0)"><strong>{{$aWord->value}}</strong></a>
                                    {{--<span>[ə,bri:vi'ei∫n]</span>--}}
                                </td>
                                <td>
                                    <span>{{$aWord->content}}</span>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="pages center block">
                            {{$allTudien->appends(array(
                                'letter' => Input::get('letter', ''),
                                'searchWord' => Input::get('searchWord'),
                                'cate' => Input::get('cate','')
                            ))->links()}}
                        </div>
                    </div>
                </div>

            </div>
            <div class="content_right">
                <div class="block">
                    <div class="heading2">
                        <div class="title_heading2">
                            <h2><a title="" href="javascript:void(0)">Tra từ điển theo chủ đề</a></h2>
                        </div>
                    </div>
                    <div class="block_categories_right">
                        <div class="list_1">
                            <ul class="ul_list_1 list_cate_dict" id="chkTopic">
                                @foreach($allCate as $aCate)
                                <li>
                                	<span>
                                        <label style="cursor: pointer"><input type="checkbox" data-id="{{$aCate->_id}}" @if(in_array($aCate->_id, $cate)) checked @endif/> {{$aCate->name}}</label>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div> <!--Block Categories Right / Bài học yêu thích-->

                @hot_lessions()
                @right_ads()
            </div>
        </div>
    </div>

    <script>
        function searchWord(){
            word = $('#txtSearchWord').val();
            window.location.href = '/tu-dien.html?letter={{$letter}}&searchWord='+word+'&cate={{Input::get('cate', '')}}';
        }

        function selectTopic(){
            cate = [];
            $('#chkTopic input').each(function(e){
                if($(this).is(':checked')){
                    cate[cate.length] = $(this).attr('data-id');
                }
            })

            window.location.href = '/tu-dien.html?letter={{$letter}}&searchWord={{Input::get('searchWord')}}&cate='+cate.join(',');
        }

        $(function(){
            $('#txtSearchWord').keyup(function(e){
                if(e.which==13 && $(this).val() != ''){
                    searchWord();
                }
            });

            $('#chkTopic input').change(function(){
                selectTopic();
            });
        })
    </script>
@endsection