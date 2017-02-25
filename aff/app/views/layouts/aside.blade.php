<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="/admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <li @if(strpos(Request::url(),'/download/keeng')) class="active" @endif>
            <a href="/download/keeng"><i class="fa fa-fw fa-edit"></i> Download Keeng.vn</a>
        </li>
        <li @if(strpos(Request::url(),'/download/zing')) class="active" @endif>
            <a href="/download/zing"><i class="fa fa-fw fa-edit"></i> Download mp3.zing.vn</a>
        </li>
        <li @if(strpos(Request::url(),'/download/nhaccuatui')) class="active" @endif>
            <a href="/download/nhaccuatui"><i class="fa fa-fw fa-edit"></i> Download nhaccuatui</a>
        </li>
        <li @if(strpos(Request::url(),'/ringtone/export')) class="active" @endif>
            <a href="/ringtone/export"><i class="fa fa-fw fa-edit"></i> Lấy bài hát nhạc chờ</a>
        </li>
        <li @if(strpos(Request::url(),'/admin/articles')) class="active" @endif>
            <a href="/admin/articles/import"><i class="fa fa-fw fa-edit"></i> Import Bài viết Suckhoe1</a>
        </li>
        <li @if(strpos(Request::url(),'/admin/clips')) class="active" @endif>
            <a href="/admin/clips/import"><i class="fa fa-fw fa-edit"></i> Import Clip Suckhoe1</a>
        </li>
        <li @if(strpos(Request::url(),'/mobifone')) class="active" @endif>
            <a href="/mobifone/export"><i class="fa fa-fw fa-edit"></i> Export Mobifone</a>
        </li>
    </ul>
</div>