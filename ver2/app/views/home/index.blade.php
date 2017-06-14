@extends('layouts.main')

@section('content')
<div class="content">
    <div class="w1170">
        <div class="content_left">
            <div class="block block_highlight_index">
                @slider()
            </div> <!--Block Highlight-->
            <div class="block">
                <div class="block_categories">
                    <div class="heading1 mgb10">
                        <div class="title_heading1">
                            <h2><a href="/{{CommonHelpers::getCateSlugbyType($famousParent->type)}}.html">{{$famousParent->name}}</a><label class="label_heading"></label></h2>
                        </div>
                        <div class="list_heading1">
                            <ul class="ul_list_heading1">
                                @foreach($famousParent->getChilds() as $aFamousChild)
                                <li><a href="{{ThuVien::getCateUrl($aFamousChild->_id, $aFamousChild->name, $aFamousChild->type)}}" title="">{{$aFamousChild->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <?php
                    $posts = ThuVien::getNewPost($famousParent->_id, 7, true);
                    $firstFamousPost = isset($posts[0]) ? $posts[0] : null;
                    $secondFamousPost = isset($posts[1]) ? $posts[1] : null;
                    unset($posts[0]);
                    unset($posts[1])
                    ?>
                    <div class="block_categories_col">
                        @if($firstFamousPost)
                        <div class="block_categories_col_1">
                            <div class="item1">
                                <a href="{{ThuVien::getArticleUrlStatic($firstFamousPost['name'], $firstFamousPost['_id'], $famousParent->type)}}">
                                    <div class="img_mask img_mask_size_2">
                                        <img src="{{$firstFamousPost['avatar']}}">
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_2">{{$firstFamousPost['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($secondFamousPost)
                        <div class="block_categories_col_2">
                            <div class="item2">
                                <a title="" href="{{ThuVien::getArticleUrlStatic($secondFamousPost['name'], $secondFamousPost['_id'], $famousParent->type)}}">
                                        <span class="img_mask img_mask_item2">
                                            <img src="{{$secondFamousPost['avatar']}}">
                                        </span>
                                    <strong class="title_item2 title_item2_font_1">{{$secondFamousPost['name']}}</strong>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="block_categories_col_3">
                            <div class="list_1">
                                <ul class="ul_list_1">
                                    @foreach($posts as $post)
                                    <li><a title="" href="{{ThuVien::getArticleUrlStatic($post['name'], $post['_id'], $famousParent->type)}}">{{$post['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div> <!--Block Categories / Người nổi tiếng-->
            <div class="block">
                <div class="block_categories">
                    <div class="heading1 mgb10">
                        <div class="title_heading1">
                            <h2><a href="/giao-tiep-co-ban.html">Giao tiếp cơ bản</a><label class="label_heading"></label></h2>
                        </div>
                        <div class="list_heading1">
                            <ul class="ul_list_heading1">
                                @foreach($allGtcbCategories as $aGtcbCate)
                                <li><a href="{{GiaoTiepCoBan::getCateUrl($aGtcbCate)}}" title="">{{$aGtcbCate->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <?php
                    $gtcb = GiaoTiepCoBan::getNewPost(7, true);
                    $firstGtcb = isset($gtcb[0]) ? $gtcb[0] : null;
                    $secondGtcb = isset($gtcb[1]) ? $gtcb[1] : null;
                    unset($gtcb[0], $gtcb[1]);
                    ?>
                    <div class="block_categories_col">
                        @if($firstGtcb)
                        <div class="block_categories_col_1">
                            <div class="item1">
                                <a href="{{GiaoTiepCoBan::getStaticDetailUrl($firstGtcb['name'], $firstGtcb['_id'])}}">
                                    <div class="img_mask img_mask_size_2">
                                        <img src="{{$firstGtcb['avatar']}}">
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_2">{{$firstGtcb['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($secondGtcb)
                        <div class="block_categories_col_2">
                            <div class="item2">
                                <a href="{{GiaoTiepCoBan::getStaticDetailUrl($secondGtcb['name'], $secondGtcb['_id'])}}">
                                        <span class="img_mask img_mask_item2">
                                            <img src="{{$secondGtcb['avatar']}}">
                                        </span>
                                    <strong class="title_item2 title_item2_font_1">{{$secondGtcb['name']}}</strong>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="block_categories_col_3">
                            <div class="list_1">
                                <ul class="ul_list_1">
                                    @foreach($gtcb as $aGtcb)
                                    <li><a title="" href="{{GiaoTiepCoBan::getStaticDetailUrl($aGtcb['name'], $aGtcb['_id'])}}">{{$aGtcb['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div> <!--Block Categories / Giao tiếp cơ bản-->
            <div class="block">
                <div class="block_categories">
                    <div class="heading1 mgb10">
                        <div class="title_heading1">
                            <h2><a href="/bai-hat.html">Bài hát</a><label class="label_heading"></label></h2>
                        </div>
                        <div class="list_heading1">
                            <ul class="ul_list_heading1">
                                @foreach($allSongCategories as $aSongCate)
                                <li><a href="{{Song::getCateUrl($aSongCate)}}" title="">{{$aSongCate->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <?php
                    $songs = Song::getNewPost(7,true);
                    $firstSong = isset($songs[0]) ? $songs[0] : null;
                    $secondSong = isset($songs[1]) ? $songs[1] : null;
                    unset($songs[0], $songs[1]);
                    ?>
                    <div class="block_categories_col">
                        @if($firstSong)
                        <div class="block_categories_col_1">
                            <div class="item1">
                                <a href="{{Song::getStaticDetailUrl($firstSong['name'], $firstSong['_id'])}}">
                                    <div class="img_mask img_mask_size_2">
                                        <img src="{{$firstSong['avatar']}}">
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_2">{{$firstSong['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($secondSong)
                        <div class="block_categories_col_2">
                            <div class="item2">
                                <a title="" href="{{Song::getStaticDetailUrl($secondSong['name'], $secondSong['_id'])}}">
                                        <span class="img_mask img_mask_item2">
                                            <img src="{{$secondSong['avatar']}}">
                                        </span>
                                    <strong class="title_item2 title_item2_font_1">{{$secondSong['name']}}</strong>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="block_categories_col_3">
                            <div class="list_1">
                                <ul class="ul_list_1">
                                    @foreach($songs as $aSong)
                                    <li><a title="" href="{{Song::getStaticDetailUrl($aSong['name'], $aSong['_id'])}}">{{$aSong['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div> <!--Block Categories / Bài hát tiếng anh-->

            <div class="block block_highlight_index block_video">
                <div class="heading_video">
                    <h2><a class="link_cate_video" href="javascript:void(0)">Video</a><label class="label_heading"></label></h2>
                    <div class="list_cate_video" style="display:none;">
                        <ul>
                            @foreach($videoParent->getChilds() as $aVideoCate)
                            <li><a href="{{ThuVien::getCateUrl($aVideoCate->_id, $aVideoCate->name, $aVideoCate->type)}}">{{$aVideoCate->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <?php
                $videos = ThuVien::getNewPost($videoParent->_id, 6, true);
                $slideVideo = array();
                $slideVideo[] = isset($videos[0]) ? $videos[0] : null;
                $slideVideo[] = isset($videos[1]) ? $videos[1] : null;
                $slideVideo[] = isset($videos[2]) ? $videos[2] : null;
                unset($videos[0], $videos[1], $videos[2]);
                ?>
                <div class="highlight_left">
                    <ul class="bxslider">
                        @foreach($slideVideo as $aSlide)
                        <li>
                            <div class="item1">
                                <a href="{{Thuvien::getArticleUrlStatic($aSlide['name'], $aSlide['_id'], $videoParent->type)}}">
                                    <div class="img_mask img_mask_size_1">
                                        <label class="play_video_btn"><i class="fa fa-fw"></i></label>
                                        <img src="{{$aSlide['avatar']}}">
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_1">{{$aSlide['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="highlight_right">
                    <ul class="list_highlight_right">
                        @foreach($videos as $aVideo)
                        <li>
                            <div class="item1">
                                <a href="{{Thuvien::getArticleUrlStatic($aVideo['name'], $aVideo['_id'], $videoParent->type)}}">
                                    <div class="img_mask img_mask_size_4">
                                        <img src="{{$aVideo['avatar']}}">
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_3">{{$aVideo['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div> <!--Block Categories / Video-->
            <div class="block">
                <div class="block_categories">
                    <div class="heading1 mgb10">
                        <div class="title_heading1">
                            <h2><a href="/{{CommonHelpers::getCateSlugbyType($radioParent->type)}}.html">Radio</a><label class="label_heading"></label></h2>
                        </div>
                        <div class="list_heading1">
                            <ul class="ul_list_heading1">
                                @foreach($radioParent->getChilds(8) as $aRadioCate)
                                    <li><a href="{{ThuVien::getCateUrl($aRadioCate->_id, $aRadioCate->name, $aRadioCate->type)}}">{{$aRadioCate->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="block_categories_col">
                        @foreach(ThuVien::getNewPost($radioParent->_id, 8, true) as $aRadio)
                        <div class="block_categories_col_x">
                            <div class="item1">
                                <a href="{{Thuvien::getArticleUrlStatic($aRadio['name'], $aRadio['_id'], $radioParent->type)}}">
                                    <div class="img_mask img_mask_size_5">
                                        <img src="{{$aRadio['avatar']}}" />
                                        <label class="img_shadow"></label>
                                        <strong class="title_item1 title_item1_font_3">{{$aRadio['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                </div>
            </div> <!--Block Categories / Radio-->
            <div class="block">
                <div class="block_categories">
                    <div class="heading1 mgb10">
                        <div class="title_heading1">
                            <h2><a href="/{{CommonHelpers::getCateSlugbyType($filmParent->type)}}.html">Phim</a><label class="label_heading"></label></h2>
                        </div>
                        <div class="list_heading1">
                            <ul class="ul_list_heading1">
                                @foreach($filmParent->getChilds() as $filmChild)
                                    <li><a href="{{ThuVien::getCateUrl($filmChild->_id, $filmChild->name, $filmChild->type)}}">{{$filmChild->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="block_categories_col">
                        @foreach(ThuVien::getNewPost($filmParent->_id, 8, true) as $aFilm)
                        <div class="block_categories_col_y">
                            <div class="item4">
                                <a href="{{Thuvien::getArticleUrlStatic($aFilm['name'], $aFilm['_id'], $filmParent->type)}}">
                                    <div class="img_mask img_mask_item_4">
                                        <img src="{{$aFilm['avatar']}}" />
                                        <strong class="title_item4 title_item1_font_3">{{$aFilm['name']}}</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                </div>
            </div> <!--Block Categories / Phim-->
        </div>
        <div class="content_right">
            <div class="block">
                <div class="heading2">
                    <div class="title_heading2">
                        <h2><a title="" href="/luyen-ngu-am.html">Ngữ âm</a></h2>
                    </div>
                </div>
                <?php
                $lna = LuyenNguAm::getNewPost(5, true);
                $firstLna = isset($lna[0]) ? $lna[0] : null;
                $secondLna = isset($lna[1]) ? $lna[1] : null;
                unset($lna[0], $lna[1]);
                ?>
                <div class="block_categories_right">
                    @if($firstLna)
                    <div class="row_1">
                        <div class="item1">
                            <a href="{{LuyenNguAm::getStaticDetailUrl($firstLna['name'], $firstLna['_id'])}}">
                                <div class="img_mask img_mask_size_3">
                                    <img src="{{$firstLna['avatar']}}">
                                    <label class="img_shadow"></label>
                                    <strong class="title_item1 title_item1_font_2">{{$firstLna['name']}}</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($secondLna)
                    <div class="row_2">
                        <div class="item3">
                            <a title="" href="{{LuyenNguAm::getStaticDetailUrl($secondLna['name'], $secondLna['_id'])}}">
                                    <span class="img_mask img_mask_item3">
                                        <img src="{{$secondLna['avatar']}}">
                                    </span>
                                <strong class="title_item3 title_item2_font_1">{{$secondLna['name']}}</strong>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="row_3">
                        <div class="list_2">
                            <ul class="ul_list_2">
                                @foreach($lna as $aLna)
                                <li><a title="{{$aLna['name']}}" href="{{LuyenNguAm::getStaticDetailUrl($aLna['name'], $aLna['_id'])}}">{{$aLna['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--Block Categories Right / Ngu am-->
            <div class="block">
                <div class="heading2">
                    <div class="title_heading2">
                        <h2><a title="" href="/{{CommonHelpers::getCateSlugbyType($expParent->type)}}.html">Kinh nghiệm</a></h2>
                    </div>
                </div>
                <?php
                $exp = ThuVien::getNewPost($expParent->_id, 5, true);
                $firstExp = isset($exp[0]) ? $exp[0] : null;
                $secondExp = isset($exp[1]) ? $exp[1] : null;
                unset($exp[0], $exp[1]);
                ?>
                <div class="block_categories_right">
                    @if($firstExp)
                    <div class="row_1">
                        <div class="item1">
                            <a href="{{ThuVien::getArticleUrlStatic($firstExp['name'], $firstExp['_id'], $expParent->type)}}">
                                <div class="img_mask img_mask_size_3">
                                    <img src="{{$firstExp['avatar']}}">
                                    <label class="img_shadow"></label>
                                    <strong class="title_item1 title_item1_font_2">{{$firstExp['name']}}</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($secondExp)
                    <div class="row_2">
                        <div class="item3">
                            <a title="" href="{{ThuVien::getArticleUrlStatic($secondExp['name'], $secondExp['_id'], $expParent->type)}}">
                                    <span class="img_mask img_mask_item3">
                                        <img src="{{$secondExp['avatar']}}">
                                    </span>
                                <strong class="title_item3 title_item2_font_1">{{$secondExp['name']}}</strong>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="row_3">
                        <div class="list_2">
                            <ul class="ul_list_2">
                                @foreach($exp as $aExp)
                                <li><a title="{{$aExp['name']}}" href="{{ThuVien::getArticleUrlStatic($aExp['name'], $aExp['_id'], $expParent->type)}}">{{$aExp['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--Block Categories Right / Kinh nghiem -->
            <div class="block">
                <div class="heading2">
                    <div class="title_heading2">
                        <h2><a title="" href="/{{CommonHelpers::getCateSlugbyType($dailyParent->type)}}.html">Tiếng anh hàng ngày</a></h2>
                    </div>
                </div>
                <?php
                $daily = ThuVien::getNewPost($dailyParent->_id, 5, true);
                $firstDaily = isset($daily[0]) ? $daily[0] : null;
                $secondDaily = isset($daily[1]) ? $daily[1] : null;
                unset($daily[0], $daily[1]);
                ?>
                <div class="block_categories_right">
                    @if($firstDaily)
                    <div class="row_1">
                        <div class="item1">
                            <a href="{{ThuVien::getArticleUrlStatic($firstDaily['name'],$firstDaily['_id'], $dailyParent->type)}}">
                                <div class="img_mask img_mask_size_3">
                                    <img src="{{$firstDaily['avatar']}}">
                                    <label class="img_shadow"></label>
                                    <strong class="title_item1 title_item1_font_2">{{$firstDaily['name']}}</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($secondDaily)
                    <div class="row_2">
                        <div class="item3">
                            <a title="" href="{{ThuVien::getArticleUrlStatic($secondDaily['name'], $secondDaily['_id'], $dailyParent->type)}}">
                                    <span class="img_mask img_mask_item3">
                                        <img src="{{$secondDaily['avatar']}}">
                                    </span>
                                <strong class="title_item3 title_item2_font_1">{{$secondDaily['name']}}</strong>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="row_3">
                        <div class="list_2">
                            <ul class="ul_list_2">
                                @foreach($daily as $aDaily)
                                <li><a title="{{$aDaily['name']}}" href="{{ThuVien::getArticleUrlStatic($aDaily['name'], $aDaily['_id'], $dailyParent->type)}}">{{$aDaily['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--Block Categories Right / Tieng anh hang ngay-->
            <div class="block">
                <div class="heading2">
                    <div class="title_heading2">
                        <h2><a title="/{{CommonHelpers::getCateSlugbyType($idiomParent->type)}}.html" href="">Thành ngữ</a></h2>
                    </div>
                </div>
                <?php
                $idiom = ThuVien::getNewPost($idiomParent->_id, 5, true);
                $firstIdiom = isset($idiom[0]) ? $idiom[0] : null;
                $secondIdiom = isset($idiom[1]) ? $idiom[1] : null;
                unset($idiom[0], $idiom[1]);
                ?>
                <div class="block_categories_right">
                    @if($firstIdiom)
                    <div class="row_1">
                        <div class="item1">
                            <a href="{{ThuVien::getArticleUrlStatic($firstIdiom['name'], $firstIdiom['_id'], $idiomParent->type)}}">
                                <div class="img_mask img_mask_size_3">
                                    <img src="{{$firstIdiom['avatar']}}">
                                    <label class="img_shadow"></label>
                                    <strong class="title_item1 title_item1_font_2">{{$firstIdiom['name']}}</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($secondIdiom)
                    <div class="row_2">
                        <div class="item3">
                            <a title="" href="{{ThuVien::getArticleUrlStatic($secondIdiom['name'], $secondIdiom['_id'], $idiomParent->type)}}">
                                    <span class="img_mask img_mask_item3">
                                        <img src="{{$secondIdiom['avatar']}}">
                                    </span>
                                <strong class="title_item3 title_item2_font_1">{{$secondIdiom['name']}}</strong>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="row_3">
                        <div class="list_2">
                            <ul class="ul_list_2">
                                @foreach($idiom as $aIdiom)
                                <li><a title="{{$aIdiom['name']}}" href="{{ThuVien::getArticleUrlStatic($aIdiom['name'], $aIdiom['_id'], $idiomParent->type)}}">{{$aIdiom['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--Block Categories Right / Thanh ngu-->
            @right_ads()


        </div>
    </div>
</div>
@if(Session::has('reg_lession_popup') && !Auth::user())
    <script>
        $(function(){
            openListCate();
        })
        function openListCate() {
            bootbox.dialog({
                message: '<div style="overflow: hidden" id="chkLession">' +
                @foreach(Common::getAllLessionType() as $key=>$aType)
                        '<label class="col-sm-6"><input type="checkbox" value="{{$key}}" @if($key==Constant::TYPE_FAMOUS) checked @endif/> {{$aType}}</label>' +
                @endforeach
                        '</div>',
                title: 'Chọn chuyên mục bạn quan tâm',
                buttons: {
                    success: {
                        label: 'Lưu',
                        className: 'btn-success',
                        callback: function () {
                            select = [];
                            $('#chkLession input').each(function () {
                                if ($(this).is(':checked'))
                                    select[select.length] = $(this).val();
                            });
                            $.post('/ajax/reg-lession', {
                                select: select
                            }, function (result) {
                                console.log(result);
                                showMss(result.message);
//                            if(result.success){
//                                location.reload();
//                            }
                            })
//                        $('.modal').modal('hide');
                        }
                    },
                }
            });
        }

    </script>
@endif
@endsection