<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$title = "Log quảng cáo";
$logcl = $dbmg->ads;
$cond = array('time'=>array('$exists'=>true));
if(isset($_GET['phone']) && !empty($_GET['phone'])){
    $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
}
if(isset($_GET['source']) && !empty($_GET['source'])){
    $cond['source'] = $_GET['source'];
}
if(isset($_GET['link']) && !empty($_GET['link'])){
    $cond['link'] = new MongoRegex('/'.$_GET['link'].'/iu');
}
if(isset($_GET['ip']) && !empty($_GET['ip'])){
    $cond['ip'] = $_GET['ip'];
}
$startdate = $_GET['start'];
$enddate = $_GET['end'];
if(isset($startdate) && !empty($startdate)){
    $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
    $cond['time']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
}
if(isset($enddate) && !empty($enddate)){
    $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
    $cond['time']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
}
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("time" => -1);
$cursor = $logcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);

parse_str($_SERVER['QUERY_STRING'], $param);
unset($param['act']);
$exportUrl = 'incoming.php?act=exportAds&'.http_build_query($param);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id,phone,source") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Quảng cáo</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-12" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $_GET['phone'] ?>">
                <input type="text" name="source" class="form-control" placeholder="Mã đối tác" value="<?php echo $_GET['source'] ?>">
                <input type="text" name="link" class="form-control" placeholder="Link" value="<?php echo $_GET['link'] ?>">
                <input type="text" name="ip" class="form-control" placeholder="IP" value="<?php echo $_GET['ip'] ?>">
                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $_GET['start'] ?>">
                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $_GET['end'] ?>">
                <input type="submit" class="btn btn-success" value="Tìm">
            </div>
            <div class="text-right" style="margin-top: 15px">
                <a class="btn btn-primary" href="<?php echo $exportUrl ?>"><i class="glyphicon glyphicon-export"></i> Export</a>
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Số điện thoại</th>
                    <th>IP</th>
                    <th>Thời gian</th>
                    <th>Source</th>
                    <th>Link</th>
                    <th>Cú pháp</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><?php echo isset($item['phone']) ? $item['phone'] : '' ?></td>
                        <td><?php echo isset($item['ip']) ? $item['ip'] : '' ?></td>
                        <td><?php echo date('d/m/Y H:i:s', $item['time']) ?></td>
                        <td><?php echo $item['source'] ?></td>
                        <td><?php echo $item['link'] ?></td>
                        <td><?php echo $item['cuphap'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






