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
        <div class="col-sm-12">
                {{Form::open(array('url'=>'/report/click','method'=>'get','class'=>'form-inline','id'=>'datePick'))}}
                {{Form::hidden('start',null,array('id'=>'dateStart'))}}
                {{Form::hidden('end',null,array('id'=>'dateEnd'))}}
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                    {{Form::text('range', $start.' - '.$end, array('class'=>'form-control','id'=>'reportrange'))}}
                </div>
            {{Form::close()}}
        </div>
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
    <script type="text/javascript">
        $(function() {
            var start = '{{$start}}';
            var end = '{{$end}}';

            function cb(start, end) {
                $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $('#dateStart').val(start.format('DD/MM/YYYY'));
                $('#dateEnd').val(end.format('DD/MM/YYYY'))
                $('#datePick').submit();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, cb);
        });
    </script>
@endsection