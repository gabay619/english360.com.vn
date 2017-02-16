@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_game block">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/game">Game</a></li>
                    </ul>
                </div>
                <div class="top_body_game block">
                    <div class="title_game block">
                        <h2 class="font_game block">Hướng dẫn chơi</h2>
                    </div>
                </div>
                <div class="middle_body_game block">
                    <div class="label_game_2 block">
                        <img class="left" src="/assets/web/images/game/label_game_2.png" />
                        <img class="right" src="/assets/web/images/game/label_game_2.png" />
                    </div>
                    <div class="select_subject_game_screen block">
                        <div class="heading_game center mgb20 block">
                            <div class="btn_area btn left">
                                <a href="/game"><img src="/assets/web/images/game/btn_undo.png" /></a>
                            </div>
                            <div class="game_h3">Hướng dẫn chơi</div>
                        </div>
                        <div class="content_text_game block">
                            <p>Để bắt đầu chơi, bạn chọn chủ đề và mức độ muốn chơi: Khó/Dễ.</p>
                            <p>Ở mức độ Dễ, mỗi level có 10 bức tranh, mỗi tranh có 4 đáp án cho bạn lựa chọn, sau khi hoàn thành lựa chọn của tất cả 10 bức tranh, bạn chọn HOÀN THÀNH để biết kết quả và số điểm đạt được. Bạn có thể click vào những câu bạn làm sai để biết được đáp án chính xác. Để chơi level tiếp theo, bạn click TIẾP TỤC NÀO.</p>
                            <p>Ở mức độ Khó, mỗi level có 10 bức tranh, dưới mỗi tranh là các ô trống để bạn nhập đáp án. Sau khi nhập xong đáp án tất cả 10 bức tranh, chọn HOÀN THÀNH để biết được số điểm giành được. Bạn có thể click vào những câu bạn làm sai để biết được kết quả chính xác. Để chơi level tiếp theo, bạn chọn TIẾP TỤC NÀO.</p>
                            <p>Để biết số điểm đạt được sau khi hoàn thành phần chơi của mình, chọn TOP NGƯỜI CHƠI.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection