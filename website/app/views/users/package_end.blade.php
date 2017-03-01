@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="content_tab_text">
        <div class="text-center" style="padding: 15px 0">
            @include('layouts._messages')
            <a href="/user/package" class="btn btn-danger">Tiếp tục</a>
        </div>
    </div>
@endsection