@extends('layouts.outform')

@section('content')
    <div class="panel-heading">
        <div class="panel-title text-center">
            <h1 class="title">Thông báo</h1>
            <hr />
        </div>
    </div>
    <div class="main-login main-center">
        @include('layouts._messages')
        <div>
            <a href="/" class="btn btn-primary btn-lg btn-block login-button">Về trang chủ</a>
        </div>
    </div>
@endsection