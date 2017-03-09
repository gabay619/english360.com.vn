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
    @datepicker($start, $end)
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <ul class="nav nav-tabs">
                <li><a href="/report/click/url">Theo URL</a></li>
                <li class="active"><a href="#">Theo nguồn</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" style="padding-top: 20px">
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
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @pagination($stpage,$rowcount,$limit)
        </div>
    </div>
@endsection