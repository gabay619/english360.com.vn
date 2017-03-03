@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="content_tab_text">
        <div class="text-center" style="padding: 15px 0">
            <p><strong class="notice_1 uppercase color_red mgb10">Vui lòng chọn hình thức thanh toán</strong></p>
        </div>
        <div class="list_bhdl block">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <a href="?step=3&pkg={{Input::get('pkg')}}&type=card">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                    <h3 class="panel-title">THẺ CÀO</h3>
                            </div>
                            <div class="panel-body">
                                <img src="/assets/images/napbangthe.png" alt="" style="width: 100%">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 text-center">
                    <a href="?step=3&pkg={{Input::get('pkg')}}&type=bank">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">THẺ ATM NỘI ĐỊA</h3>
                            </div>
                            <div class="panel-body">
                                <img src="/assets/images/napatm.jpg" alt="" style="width: 100%">
                            </div>
                        </div>
                    </a>
                </div>
                @if($selectPkg->price <= 100000)
                <div class="col-sm-4 text-center">
                    <a href="?step=3&pkg={{Input::get('pkg')}}&type=otp">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">TIN NHẮN SMS</h3>
                            </div>
                            <div class="panel-body">
                                <img src="/assets/images/napsms.png" alt="" style="width: 100%">
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if($selectPkg->price <= Auth::user()->getBalance())
                <div class="col-sm-4 text-center">
                    <a href="?step=3&pkg={{Input::get('pkg')}}&type=cash">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">SỐ DƯ TÀI KHOẢN</h3>
                            </div>
                            <div class="panel-body">
                                <h2 style="padding: 61px 0; color: #db2727">{{number_format(Auth::user()->getBalance())}}đ</h2>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection