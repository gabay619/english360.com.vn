<?php
$title = "Quản lý User";
$userCl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array();
if(isset($q)){
    $cond = array(
        '$or'=>array(
            array('namenonutf'=>new MongoRegex("/$q/iu")),
            array('_id'=>"$q"),
            array('phone'=> $q),
            array('email'=>$q),
            array('displayname'=>$q)
        )
    );
}
if(empty($_GET['from'])){
    $_GET['from'] = date('d/m/Y');
}
$convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
$cond['datecreate']['$gte'] = strtotime($convertFrom);
if(empty($_GET['to'])){
    $_GET['to'] = date('d/m/Y');
}
$convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
$cond['datecreate']['$lte'] = strtotime($convertTo);
if(!empty($_GET['chanel'])){
    switch ($_GET['chanel']){
        case 'fb':
            $cond['fbid'] = array('$ne'=>'','$exists'=>true);
            break;
        case 'gg':
            $cond['ggid'] = array('$ne'=>'','$exists'=>true);
            break;
        default:
            $cond['fbid'] = array('$exists' => false);
            $cond['ggid'] = array('$exists' => false);
            break;
    }
//    $cond['chanel'] = $_GET['chanel'];
}
if(!empty($_GET['status'])){
    switch ($_GET['status']){
        case '1':
            $cond['status'] = Constant::STATUS_DISABLE;
            break;
        case '2':
            $cond['pkg_expired'] = array('$exists'=>false);
            break;
        case '3':
            $cond['pkg_expired'] = array('$gte'=>time());
            break;
        case '4':
            $cond['pkg_expired'] = array('$lte'=>time());
            break;
        default:
            break;
    }
//    $cond['chanel'] = $_GET['chanel'];
}
$cursor = iterator_to_array($userCl->find($cond),false);
$data = [];

if(!isset($_GET['type']))
    $_GET['type'] = 'd';
$startdate = new DateTime($convertFrom);
$enddate = new DateTime($convertTo);
$period = new \DatePeriod(
    $startdate,
    new \DateInterval('P1D'),
    $enddate
);

if($_GET['type'] == 'd'){
    //thống kê ngày
    foreach($period as $k=>$dt){
        $map[$dt->format('d/m/Y')] = $k;
        $data[] = array('name'=>$dt->format('d/m/Y'), 'y'=>0);
    }
    foreach ($cursor as $aHis){
        $data[$map[date('d/m/Y',$aHis['datecreate'])]]['y']++;
    }
}else{
    //thống kê giờ
    foreach($period as $k=>$dt){
        $map[$dt->format('d/m/Y')] = $k;
        for($i=0;$i<=23;$i++){
            $dataline[$i] = 0;
        }

        $data[] = [
            'name' => $dt->format('d/m/Y'),
            'data' => $dataline
        ];
    }
    foreach ($cursor as $aHis){
        $data[$map[date('d/m/Y',$aHis['datecreate'])]]['data'][intval(date('H',$aHis['datecreate']))]++;
    }
//    print_r($data);die;
}
//else{
    //thống kê tổng
//    foreach (HistoryLog::getArr() as $k=>$val){
//        $data[$k] = [
//            'name' => $val,
//            'WEB' => 0,
//            'WAP' =>0,
//            'APP' => 0,
//            'total' => 0
//        ];
//    }
//    $data['total'] = [
//        'name' => 'Total',
//        'WEB' => 0,
//        'WAP' =>0,
//        'APP' => 0,
//        'total' => 0
//    ];
//    foreach ($cursor as $aHis) {
//        if(isset($data[$aHis['action']]['name'])){
//            $data[$aHis['action']][$aHis['chanel']]++;
//            $data[$aHis['action']]['total']++;
//            $data['total'][$aHis['chanel']]++;
//            $data['total']['total']++;
//        }
//    }
//    print_r($data['total']);
//}
?>
    <script src="plugin/highchart/js/highcharts.js"></script>
    <script src="plugin/highchart/js/modules/exporting.js"></script>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li><a href="<?php echo cpagerparm("tact,id") ?>">Danh sách</a></li>
        <li class="active"><a href="#black" role="tab" data-toggle="tab">Biểu đồ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="black">
            <div>
                <?php if(acceptpermiss("user_insert")) { ?><a class="btn btn-sm btn-primary" href="<?php echo cpagerparm("tact,id,status") ?>tact=user_insert">Thêm mới</a><?php } ?>
            </div>
            <div style="margin-top: 10px">
                <form class="form-inline" role="form" action="" method="get">
                    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Kiểu thống kê: </label>
                        <label for="type_d" style="font-weight: normal"><input type="radio" name="type" value="d" id="type_d" <?php echo $_GET['type'] == 'd' ? 'checked' : ''?>> Theo ngày</label>
                        <label for="type_h" style="font-weight: normal"><input type="radio" name="type" value="h" id="type_h" <?php echo $_GET['type'] == 'h' ? 'checked' : ''?>> Theo giờ</label>
                    </div>
                    <div class="form-group">
                        <div class="form-group" style="margin-bottom: 5px">
                            <input type="text" placeholder="Tên/số điện thoại/email" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
                            <input type="text" placeholder="Từ ngày:" name="from" class="form-control datepicker" value="<?php echo $_GET['from'] ?>">
                            <input type="text" placeholder="Đến ngày:" name="to" class="form-control datepicker" value="<?php echo $_GET['to'] ?>">
                            <select name="status" class="form-control">
                                <option value="">--Trạng thái--</option>
                                <option value="1" <?php if($_GET['status']==1) echo 'selected' ?>>Chưa kích hoạt</option>
                                <option value="2" <?php if($_GET['status']==2) echo 'selected' ?>>Chưa mua khóa học</option>
                                <option value="3" <?php if($_GET['status']==3) echo 'selected' ?>>Khóa học hiệu lực</option>
                                <option value="4" <?php if($_GET['status']==4) echo 'selected' ?>>Khóa học hết hạn</option>
                            </select>
                            <select name="chanel" class="form-control">
                                <option value="">--Kênh--</option>
                                <option value="fb" <?php if($_GET['chanel']=='fb') echo 'selected' ?>>Facebook</option>
                                <option value="gg" <?php if($_GET['chanel']=='gg') echo 'selected' ?>>Google</option>
                                <option value="tt" <?php if($_GET['chanel']=='tt') echo 'selected' ?>>Trực tiếp</option>
                            </select>
                            <input type="submit" class="btn btn-success" value="Tìm">
                        </div>
                    </div>
                </form>
            </div>

            <div style="margin-top: 30px"></div>
            <div id="container" style="min-width: 310px; height: 600px; margin: 30px auto"></div>
        </div>
        <script type="text/javascript">

            $(function () {
                $('#container').highcharts({
                    <?php if($_GET['type']=='d'): ?>
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Biểu đồ đăng ký user theo ngày'
                    },
                    xAxis: {
                        title: 'Ngày',
                        type: 'category'
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Số lượng'
                        }
                    },
                    series: [{
                        name: 'User',
                        data: <?php echo json_encode($data)?>
                    }]
                    <?php else: ?>
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Biểu đồ đăng ký user theo giờ'
                    },
                    xAxis: {
                        title: 'Giờ',
                        categories: <?php echo json_encode(range(0,23)) ?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Số User'
                        }
                    },
                    series: <?php echo json_encode($data) ?>
                    <?php endif; ?>
                });
            });

        </script>
        </div>
    </div>
<?php include("component/paging.php") ?>