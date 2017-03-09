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
                <li class="active"><a data-toggle="tab" href="#">Theo URL</a></li>
                <li><a href="/report/click/source">Theo nguồn</a></li>
            </ul>

            <div class="tab-content">
                <div  class="tab-pane fade in active" style="padding-top: 20px">
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @pagination($stpage,$rowcount,$limit)
        </div>
    </div>
@endsection