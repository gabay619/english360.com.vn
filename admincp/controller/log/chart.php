<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$title = "Lịch sử sử dụng";
$logcl = $dbmg->history_log;
$usercl = $dbmg->user;
$cond = array();
if(!empty($_GET['email'])){
    $user = $usercl->findOne(array('email' => $_GET['email']));
    if($user)
        $cond['uid'] = $user['_id'];
}
if(!empty($_GET['ip'])){
    $cond['ip'] = $_GET['ip'];
}
if(!empty($_GET['action'])){
    $cond['action'] = $_GET['action'];
}
if(!empty($_GET['ref'])){
    $cond['ref'] = $_GET['ref'];
}
if(!empty($_GET['chanel'])){
    $cond['chanel'] = $_GET['chanel'];
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

$cursor = iterator_to_array($logcl->find($cond),false);
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
}else if($_GET['type'] == 'h'){
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
}else{
    //thống kê tổng
    foreach (HistoryLog::getArr() as $k=>$val){
        $data[$k] = [
            'name' => $val,
            'WEB' => 0,
            'WAP' =>0,
            'APP' => 0,
            'total' => 0
        ];
    }
    $data['total'] = [
        'name' => 'Total',
        'WEB' => 0,
        'WAP' =>0,
        'APP' => 0,
        'total' => 0
    ];
    foreach ($cursor as $aHis) {
        if(isset($data[$aHis['action']]['name'])){
            $data[$aHis['action']][$aHis['chanel']]++;
            $data[$aHis['action']]['total']++;
            $data['total'][$aHis['chanel']]++;
            $data['total']['total']++;
        }
    }
//    print_r($data['total']);
}

?>
<script src="plugin/highchart/js/highcharts.js"></script>
<script src="plugin/highchart/js/modules/exporting.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li><a href="<?php echo cpagerparm("tact,id") ?>">Lịch sử sử dụng</a></li>
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Biểu đồ</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group" style="margin-bottom: 10px">
                <label for="">Kiểu thống kê: </label>
                <label for="type_d" style="font-weight: normal"><input type="radio" name="type" value="d" id="type_d" <?php echo $_GET['type'] == 'd' ? 'checked' : ''?>> Theo ngày</label>
                <label for="type_h" style="font-weight: normal"><input type="radio" name="type" value="h" id="type_h" <?php echo $_GET['type'] == 'h' ? 'checked' : ''?>> Theo giờ</label>
                <label for="type_dt" style="font-weight: normal"><input type="radio" name="type" value="dt" id="type_dt" <?php echo $_GET['type'] == 'dt' ? 'checked' : ''?>> Theo số liệu</label>
            </div>
            <div class="form-group" style="margin-bottom: 5px">
                <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $_GET['email'] ?>">
                <input type="text" name="ip" class="form-control" placeholder="IP" value="<?php echo $_GET['ip'] ?>">
                <input type="text" placeholder="Từ ngày:" name="from" class="form-control datepicker" value="<?php echo $_GET['from'] ?>">
                <input type="text" placeholder="Đến ngày:" name="to" class="form-control datepicker" value="<?php echo $_GET['to'] ?>">
                <select name="chanel" class="form-control">
                    <option value="">Kênh</option>
                    <?php foreach(HistoryLog::getChanelArr() as $key=>$val):?>
                        <option value="<?php echo $key?>" <?php if($key==$_GET['chanel']) echo 'selected'?>><?php echo $val?></option>
                    <?php endforeach; ?>
                </select>
                <select name="action" class="form-control">
                    <option value="">--Hành động--</option>
                    <?php foreach(HistoryLog::getArr() as $key=>$val):?>
                        <option value="<?php echo $key?>" <?php if($key==$_GET['action']) echo 'selected'?>><?php echo $val?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" placeholder="Nguồn" name="ref" class="form-control" value="<?php echo $_GET['ref'] ?>">
                <input type="submit" class="btn btn-success" value="Tìm">
            </div>
        </form>
        <div style="margin-top: 30px"></div>
        <?php if($_GET['type']=='dt'): ?>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Hành động</th>
                <th>WEB</th>
                <th>WAP</th>
                <th>APP</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key=>$val): ?>
                <tr>
                    <td><?php echo $val['name'] ?></td>
                    <td><?php echo $val['WEB'] ?></td>
                    <td><?php echo $val['WAP'] ?></td>
                    <td><?php echo $val['APP'] ?></td>
                    <td><?php echo $val['total'] ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php else: ?>
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
                    text: 'Biểu đồ truy cập ngày'
                },
                xAxis: {
                    title: 'Ngày',
                    type: 'category'
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Truy cập'
                    }
                },
                series: [{
                    name: 'Hành động',
                    data: <?php echo json_encode($data)?>
                }]
                <?php elseif ($_GET['type']=='h'): ?>
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Biểu đồ truy cập theo giờ'
                },
                xAxis: {
                    title: 'Giờ',
                    categories: <?php echo json_encode(range(0,23)) ?>
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Truy cập'
                    }
                },
                series: <?php echo json_encode($data) ?>
                <?php endif; ?>
            });
        });

    </script>
    <?php endif; ?>
</div>






