@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Thông báo
            </h1>
        </div>
    </div>
    <div class="page-wrapper">
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
            @include('layouts._messages')
        </div>
    </div>
@endsection