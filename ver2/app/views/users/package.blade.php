@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="content_tab_text">
        <div class="text-center" style="padding: 15px 0">
            <p>
                English360 cung cấp cho bạn những khóa học <strong>chất lượng</strong> với học phí <strong>hấp dẫn</strong> và <strong>linh hoạt</strong>.
            </p>
            <p>
                Sau khi mua khóa học, bạn được học toàn bộ các khóa học của English360 trong thời gian đăng ký.
            </p>
        </div>
        <div class="list_bhdl block">
            <div class="row">
                @foreach($packages as $aPack)
                    <div class="col-sm-3 text-center">
                        <a href="?step=2&pkg={{$aPack->_id}}">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{$aPack->name}}</h3>
                                </div>
                                <div class="panel-body">
                                    <h3>{{number_format($aPack->price)}}đ</h3>
                                    <p class="help-block">{{$aPack->description}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection