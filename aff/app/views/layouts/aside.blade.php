<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li @if(strpos(Request::url(),'/dashboard')) class="active" @endif>
            <a href="/dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <li @if(strpos(Request::url(),'/link/new')) class="active" @endif>
            <a href="/link/new"><i class="fa fa-fw fa-edit"></i> Tạo link phân phối</a>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#report"><i class="fa fa-fw fa-bar-chart-o"></i> Báo cáo <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="report" class="collapse @if(strpos(Request::url(),'/report')) in @endif">
                <li>
                    <a href="/report/click">Lượt click</a>
                </li>
                <li>
                    <a href="/report/user">Khách hàng</a>
                </li>
                <li>
                    <a href="/report/txn">Lịch sử giao dịch</a>
                </li>
                <li>
                    <a href="/report/summarize">Sản lượng</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#payment"><i class="fa fa-fw fa-dollar"></i> Thanh toán <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="payment" class="collapse @if(strpos(Request::url(),'/payment')) in @endif">
                {{--<li>--}}
                    {{--<a href="/payment/withdraw">Rút tiền</a>--}}
                {{--</li>--}}
                <li>
                    <a href="/payment/info">Thông tin thanh toán</a>
                </li>
                <li>
                    <a href="/payment/list">Lịch sử thanh toán</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#sup"><i class="fa fa-fw fa-question-circle"></i> Hỗ trợ <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="sup" class="collapse">
                <li>
                    <a href="#">Hướng dẫn</a>
                </li>
                <li>
                    <a href="#">Quy định/Chính sách</a>
                </li>
            </ul>
        </li>
    </ul>
</div>