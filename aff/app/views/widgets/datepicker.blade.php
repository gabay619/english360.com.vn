<div class="row" style="margin-bottom: 10px">
    <div class="col-sm-12">
        {{Form::open(array('url'=>$url,'method'=>'get','class'=>'form-inline','id'=>'datePick'))}}
        {{Form::hidden('start',null,array('id'=>'dateStart'))}}
        {{Form::hidden('end',null,array('id'=>'dateEnd'))}}
        <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
            {{Form::text('range', $start.' - '.$end, array('class'=>'form-control','id'=>'reportrange'))}}
        </div>
        {{Form::close()}}
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