@extends('layouts.detail', array(
))

@section('content')
<table class="table table-bordered" id="tablePhone">
    <thead>
    <tr>
        <td>STT</td>
        <td>Phone</td>
        <td>Result</td>
    </tr>
    </thead>
    <tbody>
    @foreach($user as $k=>$u)
        <tr>
            <td>{{$k+1}}</td>
            <td class="phone">{{$u->phone}}</td>
            <td class="kq"></td>
        </tr>
    @endforeach
    </tbody>
</table>
    <button class="btn btn-primary" onclick="start()">Start</button>
<div>
    <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">
        <div id="process" style="background: green; height: 10px; width: 0;"></div>
    </div>
    <div class="text-center">
        <span id="percent"></span>
    </div>
</div>
<script>
    var index = 0;
    var max = {{$k+1}};

    function start(){
        $('#percentBar').show();
        $('#percent').show();
        fix();
    }

    function fix() {
        $data = $('#tablePhone tbody tr').eq(index);
        if(!$data.length){
            alert('Hoàn thành!');
            return false;
        }
        phone = $data.find('.phone').html();
//        email = $data.find('.email').html();
        $.post('/test/fix-user', {
            phone: phone
        }, function (re) {
            if(!re.del){
                $data.find('.kq').addClass('text-success').html('Updated');
            }else{
                $data.find('.kq').addClass('text-danger').html('Deleted');
            }
            var percent = (parseInt(index)+1)*100/max;
            showPercent(Math.ceil(percent));
            index++;
            fix();
        }, 'json')
    }

    function showPercent(number){
        $('#process').css('width', number+'%');
        $('#percent').html(number+'%');
    }
</script>
@endsection