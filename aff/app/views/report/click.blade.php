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
        @datepicker($start, $end, '/report/click')
        <div class="col-sm-12 col-lg-6">
            <h2>Theo URL</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>Click</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clickByUrl as $click)
                    <tr>
                        <td><a href="{{$click['_id']}}" target="_blank">{{$click['_id']}}</a></td>
                        <td>{{$click['numclick']}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h2>Theo nguồn</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nguồn</th>
                        <th>Click</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clickBySub as $click)
                        <tr>
                            <td>{{$click['_id']}}</td>
                            <td>{{$click['numclick']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection