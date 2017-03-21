@extends('layouts.outform', array(
    'title' => $item->name
))

@section('content')
    <!-- Page Heading -->
    <div class="container" style="color: #9d9d9d; margin-top: 50px">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{$item->name}}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if($item)
                        {{$item->content}}
                @else
                <h2 class="heading4 heading_detail">
                    Trang này không tồn tại.
                </h2>
                <div class="table_detail row" style="margin-top: 25px">
                    <a href="/" class="btn btn-primary">Về trang chủ</a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection