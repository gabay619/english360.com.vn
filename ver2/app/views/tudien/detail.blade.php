@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="w1170">
            <div class="content_left pd_20">
                <div class="block block_dict">
                    <div class="breadcrum block">
                        <ul class="ul_breadcrum">
                            <li><a href="/">Trang chủ</a></li>
                            <li><a href="/tu-dien.html">Từ điển</a></li>
                        </ul>
                    </div>
                    <div class="block search_dict">
                        <div class="block search_dict_alphabet">
                            @for($i=0; $i <= 25; $i++)
                                <a href="/tu-dien.html?letter={{strtoupper(Common::numtoalpha($i))}}&searchWord={{Input::get('searchWord')}}" @if(strtoupper($word->key) == strtoupper(Common::numtoalpha($i))) class="active" @endif>{{Common::numtoalpha($i)}}</a>
                            @endfor

                        </div>
                        <div class="block search_dict_input">
                            <input type="text" placeholder="Từ khóa cần tra..." id="txtSearchWord" value="{{Input::get('searchWord')}}"/>
                            <a href="javascript:searchWord()" class="btn_x btn_blue btn_luubaihoc mgt10 mgl10 mgb10 btn_search_dict">Tra từ</a>
                        </div>
                    </div>
                    <div class="content_dict">
                        <div class="detail_item_dict block">
                            <h2 class="heading_dict block">{{$word->value}}</h2>
                            <div class="content_detail_item_dict block">
                                <div class="reading_item_dict block">
                                    <p><i>['eibl]</i><i class="fa fa-fw icon_sound"></i></p>
                                </div>
                                <p class="ub">Tính từ</p>
                                <p class="icon_star">có năng lực; có tài; lành nghề</p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">an</a>
                                        <a href="">able</a>
                                        <a href="">co-op</a>
                                        <a href="">manager</a>
                                    </span>
                                    <span class="block e2">
                                    	một chủ nhiệm hợp tác xã có năng lực
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">an</a>
                                        <a href="">able</a>
                                        <a href="">writer</a>
                                    </span>
                                    <span class="block e2">
                                    	một nhà văn có tài
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">an</a>
                                        <a href="">able</a>
                                        <a href="">co-op</a>
                                        <a href="">manager</a>
                                    </span>
                                    <span class="block e2">
                                    	một chủ nhiệm hợp tác xã có năng lực
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">an</a>
                                        <a href="">able</a>
                                        <a href="">worker</a>
                                    </span>
                                    <span class="block e2">
                                    	một công nhân lành nghề
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">the</a>
                                        <a href="">ablest</a>
                                        <a href="">/most</a>
                                        <a href="">able</a>
                                        <a href="">student</a>
                                        <a href="">in the</a>
                                        <a href="">class</a>
                                    </span>
                                    <span class="block e2">
                                    	sinh viên có khả năng nhất trong lớp
                                    </span>
                                </p>
                                <p class="ub">Hậu tố</p>
                                <p class="icon_star">Có một tính cách nào đó</p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">Fashionable</a>
                                    </span>
                                    <span class="block e2">
                                    	Hợp thời trang
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">comfortable</a>
                                    </span>
                                    <span class="block e2">
                                    	Thoải mái
                                    </span>
                                </p>
                                <p class="icon_star">Có thể, cần được</p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">Eatable</a>
                                    </span>
                                    <span class="block e2">
                                    	Có thể ăn được
                                    </span>
                                </p>
                                <p class="e">
                                	<span class="block e1">
                                        <a href="">Payable</a>
                                    </span>
                                    <span class="block e2">
                                    	Cần được thanh toán
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content_right">
                <div class="block">
                    <div class="heading2">
                        <div class="title_heading2">
                            <h2><a title="" href="">Tra từ điển theo chủ đề</a></h2>
                        </div>
                    </div>
                    <div class="block_categories_right">
                        <div class="list_1">
                            <ul class="ul_list_1 list_cate_dict">
                                @foreach($allCate as $aCate)
                                    <li>
                                	<span>
                                    	<label><input type="checkbox" /></label>
                                        <label>{{$aCate->name}}</label>
                                    </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="block">
                            <a class="btn_x btn_blue btn_luubaihoc mgt10 mgl10 mgb10" href="">Tra từ</a>
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
            window.location.href = '/tu-dien.html?searchWord='+word;
        }

        $(function(){
            $('#txtSearchWord').keyup(function(e){
                if(e.which==13 && $(this).val() != ''){
                    searchWord();
                }
            });
        })
    </script>
@endsection