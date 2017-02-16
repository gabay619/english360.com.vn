<?php
$title = "Gửi thông báo Đồng hành cùng HSSV";
$userCl = $dbmg->user;
$listUser = iterator_to_array($userCl->find(array('event'=>Event::HOC_SINH_SINH_VIEN), array('phone','email')), false);
//require_once 'plugin/phpexcel/Classes/PHPExcel/IOFactory.php';
//if (!file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/HSSV.xlsx")) {
//    exit(json_encode(array('success'=>false, 'mss'=>'File không tồn tại.')));
//}
//$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads/HSSV.xlsx");
//$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

#condition
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="row">
    <button class="btn btn-primary" onclick="$(this).prop('disabled','true');startMT()">Bắt đầu gửi</button>
    <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">
        <div id="process" style="background: green; height: 10px; width: 0;"></div>
    </div>
    <div class="text-center">
        <span id="percent"></span>
    </div>
</div>
<table class="table table-hover" id="tableMT">
    <thead>
    <tr>
        <th>ID</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Trạng thái</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($listUser as $k=>$value){
        ?>
        <tr>
            <td class="uid"><?php echo $value['_id'] ?></td>
            <td class="phone"><?php echo $value['phone'] ?></td>
            <td class="email"><?php echo $value['email'] ?></td>
            <td class="hoan-thanh"></td>
        </tr>
    <?php
    }?>
    </tbody>
</table>
<script>
    var index = 0;
    var max = <?php echo $k+1 ?>;
    function startMT() {
        $('#percentBar').show();
        $('#percent').show();
        sendMT();
    }
    
    function sendMT() {
        $data = $('#tableMT tbody tr').eq(index);
        if(!$data.length){
            alert('Hoàn thành!');
            return false;
        }
        uid = $data.find('.uid').html();
//        email = $data.find('.email').html();
        $.post('incoming.php?act=mtHssv', {
            uid: uid
        }, function (re) {
            if(re.success){
                $data.find('.hoan-thanh').addClass('text-success').html('Success');
            }else{
                $data.find('.hoan-thanh').addClass('text-danger').html('Failed');
            }
            var percent = (parseInt(index)+1)*100/max;
            showPercent(Math.ceil(percent));
            index++;
            sendMT();
        }, 'json')
    }

    function showPercent(number){
        $('#process').css('width', number+'%');
        $('#percent').html(number+'%');
    }
</script>