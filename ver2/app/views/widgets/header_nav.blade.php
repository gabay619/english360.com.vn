<div class="menu_header">
    <div class="w1170">
        <ul class="list_menu_header">
            <li><h2><a class="active home" href="/" title=""><i class="fa fa-fw"></i></a></h2></li>
            <li>
                <h2><a href="/nguoi-noi-tieng.html" title="">Người nổi tiếng</a></h2>
                <ul class="sub_menu_header">
                    @foreach($famousParent->getChilds() as $aFamousCate)
                    <li><h2><a href="{{ThuVien::getCateUrl($aFamousCate->_id, $aFamousCate->name, $aFamousCate->type)}}" title="">{{$aFamousCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/giao-tiep-co-ban.html" title="">Giao tiếp cơ bản</a></h2>
                {{--<ul class="sub_menu_header">--}}
                    {{--@foreach($allGtcbCategories as $aGtcbCate)--}}
                        {{--<li><h2><a href="{{GiaoTiepCoBan::getCateUrl($aGtcbCate)}}" title="">{{$aGtcbCate->name}}</a></h2></li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            </li>
            <li>
                <h2><a href="/bai-hat.html" title="">Bài hát</a></h2>
                <ul class="sub_menu_header">
                    @foreach($allSongCategories as $aSongCate)
                        <li><h2><a href="{{Song::getCateUrl($aSongCate)}}" title="">{{$aSongCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/video.html" title="">Video</a></h2>
                <ul class="sub_menu_header">
                    @foreach($videoParent->getChilds() as $aVideoCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($aVideoCate->_id, $aVideoCate->name, $aVideoCate->type)}}" title="">{{$aVideoCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/radio.html" title="">Radio</a></h2>
                <ul class="sub_menu_header">
                    @foreach($radioParent->getChilds() as $aRadioCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($aRadioCate->_id, $aRadioCate->name, $aRadioCate->type)}}" title="">{{$aRadioCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/phim.html" title="">Phim</a></h2>
                <ul class="sub_menu_header">
                    @foreach($filmParent->getChilds() as $aFilmCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($aFilmCate->_id, $aFilmCate->name, $aFilmCate->type)}}" title="">{{$aFilmCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/{{CommonHelpers::getCateSlugbyType($dailyParent->type)}}.html" title="">Tiếng anh hàng ngày</a></h2>
                <ul class="sub_menu_header">
                    @foreach($dailyParent->getChilds() as $DailyCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($DailyCate->_id, $DailyCate->name, $DailyCate->type)}}" title="">{{$DailyCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li><h2><a href="/{{CommonHelpers::getCateSlugbyType($idiomParent->type)}}.html" title="">Thành ngữ</a></h2></li>
            <li><h2><a href="/game" title="">Trò chơi</a></h2></li>
            <li><h2><a href="/luyen-ngu-am.html" title="">Ngữ âm</a></h2></li>
            <li>
                <h2><a href="/{{CommonHelpers::getCateSlugbyType($expParent->type)}}.html" title="">Kinh nghiệm</a></h2>
                <ul class="sub_menu_header">
                    @foreach($expParent->getChilds() as $expCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($expCate->_id, $expCate->name, $expCate->type)}}" title="">{{$expCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <h2><a href="/{{CommonHelpers::getCateSlugbyType($shareParent->type)}}.html" title="">Chia sẻ</a></h2>
                <ul class="sub_menu_header">
                    @foreach($shareParent->getChilds() as $shareCate)
                        <li><h2><a href="{{ThuVien::getCateUrl($shareCate->_id, $shareCate->name, $shareCate->type)}}" title="">{{$shareCate->name}}</a></h2></li>
                    @endforeach
                </ul>
            </li>
            {{--<li><h2><a href="/tu-dien.html" title="">Từ điển</a></h2></li>--}}
            <li><h2><a href="/hoi-dap.html" title="">Hỏi đáp</a></h2></li>
            <li><h2><a href="/user/package" title="">Học phí</a></h2></li>
            {{--<li><h2><a href="/hoi-dap.html" title="" class="">Giới thiệu</a></h2></li>--}}
        </ul>
    </div>
</div>