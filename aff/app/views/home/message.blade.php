@extends('layouts.outform')

@section('content')
    <div class="container" style="color: #9d9d9d; margin-top: 50px">
        <div class="panel-heading">
            <div class="panel-title text-center">
                <h1 class="title">Thông báo</h1>
                <hr />
            </div>
        </div>
        <div class="main-login main-center">
            @include('layouts._messages')
            <div class="text-center">
                <a href="/" class="btn btn-primary btn-lglogin-button">Về trang chủ</a>
            </div>
        </div>
    </div>
@endsection