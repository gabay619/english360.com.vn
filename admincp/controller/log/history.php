<?php
$title = "Lịch sử sử dụng";
$logcl = $dbmg->history_log;
$usercl = $dbmg->user;
$cond = array();
if(!empty($_GET['phone'])){
    $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
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
if(!empty($_GET['from'])){
    $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
    $cond['datecreate']['$gte'] = strtotime($convertFrom);
}
if(!empty($_GET['to'])){
    $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
    $cond['datecreate']['$lte'] = strtotime($convertTo);
}
//print_r($cond);
$limit = 15;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $logcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
parse_str($_SERVER['QUERY_STRING'], $param);
unset($param['act']);
$exportUrl = 'incoming.php?act=exportHistory&'.http_build_query($param);

?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Lịch sử sử dụng</a></li>
    <li><a href="<?php echo cpagerparm("tact,id") ?>tact=log_chart">Biểu đồ</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group" style="margin-bottom: 5px">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $_GET['phone'] ?>">
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
            <div class="text-right" style="margin-top: 15px">
                <a class="btn btn-primary" href="<?php echo $exportUrl ?>"><i class="glyphicon glyphicon-export"></i> Export</a>
            </div>
        </form>
        <form action="" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Số điện thoại</th>
                    <th>Username</th>
                    <th>Hành động</th>
                    <th>URL</th>
                    <th>IP</th>
                    <th>Kênh</th>
                    <th>Giá tiền</th>
                    <th>Nguồn</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) {
                    $user = $item['uid'] ? $usercl->findOne(array('_id'=>$item['uid'])) : false;
                    ?>
                    <tr>
                        <td><?php echo $item['phone'] ?></td>
                        <td><?php echo $user ? $user['username'] : '' ?></td>
                        <td><?php echo HistoryLog::getArr()[$item['action']] ?></td>
                        <td><a href="<?php echo $item['url'] ?>" target="_blank">LINK</a></td>
                        <td><?php echo $item['ip'] ?></td>
                        <td><?php echo $item['chanel'] ?></td>
                        <td><?php echo isset($item['price']) ? $item['price'] : 0 ?></td>
                        <td><?php echo isset($item['ref']) ? $item['ref'] : '' ?></td>
                        <td><?php echo date('d/m/Y H:i:s', $item['datecreate']) ?></td>
                        <td><?php echo $item['status'] == Constant::STATUS_ENABLE ? 'Thành công' : 'Thất bại' ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






