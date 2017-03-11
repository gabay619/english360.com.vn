@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Sản lượng
            </h1>
        </div>
    </div>
    @datepicker($start, $end)
    <div class="row">
        <div class="col-sm-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Loại</th>
                        <th>Số lượt</th>
                        <th>Tổng giá trị</th>
                        <th>Tổng chiết khấu</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($summarize as $item)
                        <tr>
                            <td>{{Common::getPaymentMethod($item['_id'])}}</td>
                            <td>{{$item['count']}}</td>
                            <td>{{number_format($item['sum_amount'])}}</td>
                            <td>{{number_format($item['sum_discount'])}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            <div class="col-sm-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Tỷ lệ doanh thu</h3>
                    </div>
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script>
        $(function () {
            var data = [
                @foreach($summarize as $item)
                {
                label: "{{Common::getPaymentMethod($item['_id'])}}",
                data: {{$item['sum_discount']}}
            },
                @endforeach
               ];
            $.plot('#flot-pie-chart', data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });
        })

    </script>
@endsection