<ul class="tab-legend">
    <li @if(strpos(Request::url(),'package')) class="active" @endif><a href="/user/package"><i class="fa fa-fw"></i> @if($checkPackage != 1)Đăng ký gói cước @else Thông tin gói cước @endif</a></li>
    <li @if(strpos(Request::url(),'reg-lession')) class="active" @endif><a href="/user/reg-lession"><i class="glyphicon glyphicon-send"></i> Đăng ký bài học</a></li>
    <li @if(strpos(Request::url(),'profile')) class="active" @endif><a href="/user/profile"><i class="fa fa-fw"></i>Cài đặt riêng tư</a></li>
    <li @if(strpos(Request::url(),'save-lession')) class="active" @endif><a href="/user/save-lession"><i class="fa fa-fw"></i>Bài học đã lưu</a></li>
    <li @if(strpos(Request::url(),'question')) class="active" @endif><a href="/user/question"><i class="fa fa-fw"></i>Câu hỏi của bạn</a></li>
    <li @if(strpos(Request::url(),'notify')) class="active" @endif><a href="/user/notify"><i class="fa fa-comments"></i>Thông báo của bạn</a></li>
    <li><a href="/user/logout"><i class="fa fa-fw"></i>Thoát</a></li>
</ul>