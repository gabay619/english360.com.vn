@extends('layouts.outside')

@section('content')
    <div class="container-fluid c1">
        <div class="row text-center">
            <h2>Cơ hội làm việc với English360</h2>
            <h3>Kiếm từ 20.000.000 đồng/tháng bằng cách chia sẻ đến cộng đồng chương trình học tiếng Anh giao tiếp chất lượng</h3>
            <a class="action-button shadow animate red btn-dangkyngay btn" href="/user/register">Đăng ký ngay</a>
            <div class="text-center">
                <p>Đã có tài khoản, vui lòng <a href="/user/login">Đăng nhập</a></p>
            </div>
        </div>
    </div>

    <div class="container c2">
        <div class="">
            <div class="col-md-6 c2-cover">
                <img src="{{asset('media/aff/images/c2-cover.png')}}" alt="" style="width: 100%">
            </div>
            <div class="col-md-6 c2-content c-content">
                <div class="title mgt50 mgb30">Về chúng tôi</div>
                <p>English360 là kênh học tiếng Anh giao tiếp, giúp người học rèn luyện các kỹ năng nghe, nói và ngữ âm. English360 có trên 2 nền tảng website và wapsite.</p>
                <p>English360 cung cấp những bài học mang tính ứng dụng cao qua các bộ phim, ca khúc nổi tiếng hay những mẩu chuyện thú vị. Nội dung các bài học được dàn dựng công phu và nhận được đánh giá cao của giới chuyên môn.</p>
            </div>
        </div>
    </div>

    <div class="container-fluid c3fl">
        <div class="container c3">
            <div class="row text-center">
                <div class="title mgt10 mgb50">Các bước kiếm tiền với English360</div>
            </div>
            <div class="row c3-content">
                <div class="col-md-3">
                    <div class="services-post">
                        <span><i class="fa fa-user" aria-hidden="true"></i></span>
                        <h2>1. Đăng ký tài khoản</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services-post">
                        <span><i class="fa fa-cog" aria-hidden="true"></i></span>
                        <h2>2. Tạo link phân phối</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services-post">
                        <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                        <h2>3. Chia sẻ link</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services-post">
                        <span><i class="fa fa-dollar" aria-hidden="true"></i></span>
                        <h2>4. Nhận hoa hồng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row c4">
            <div class="col-sm-6 middleDiv title-c4 text-center">
                <h4>Tại sao bạn nên chọn hợp tác với English360</h4>
            </div>
            <div class="col-sm-6 c4-left middleDiv">
                <p>
                    1. Miễn phí tham gia hệ thống <br>
                    2. Phương thức sử dụng đơn giản <br>
                    3. Hoa hồng lên đến 30% cho mỗi khoá học thành công <br>
                    4. Thu nhập được thể hiện rõ ràng, minh bạch và tức thì
                </p>
            </div>
        </div>
    </div>
@endsection