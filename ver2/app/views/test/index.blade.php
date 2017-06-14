@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')
    <div class="content_tab_text">
        <h4 class="title_1">Cấu trúc bài kiểm tra</h4>
        <p> - Thời gian làm bài: 25 phút</p>
        <p> - Số lượng: 24 câu hỏi trắc nghiệm, viết lại câu, điền từ</p>
        <p> - Gồm 4 phần</p>
        <p> 1. Ngữ pháp</p>
        <p> 2. Từ vựng</p>
        <p> 3. Nghe hiểu</p>
        <p> 4. Đọc hiểu</p>
    </div>
    <div class="text-center">
        <a href="/test/run" class="btn_x btn_blue btn_padding bold">Bắt đầu làm bài kiểm tra</a>
    </div>
@endsection