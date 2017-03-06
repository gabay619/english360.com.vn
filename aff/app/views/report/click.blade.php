@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Báo cáo click
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <h2>Số lượt click</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>Lượt click</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allClick as $click)
                    <tr>
                        <td><a href="{{$click['_id']}}" target="_blank">{{$click['_id']}}</a></td>
                        <td>{{$click['numclick']}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection