<?php
$title = "Log truy cập 3g";
$logcl = $dbmg->log3g;
$cond = array();
if(isset($_GET['phone'])){
    $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
}
if(!empty($_GET['from'])){
    $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
    $cond['datecreate']['$gte'] = strtotime($convertFrom);
}
if(!empty($_GET['to'])){
    $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
    $cond['datecreate']['$lte'] = strtotime($convertTo);
}
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $logcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
parse_str($_SERVER['QUERY_STRING'], $param);
unset($param['act']);
$exportUrl = 'incoming.php?act=exportLog3g&'.http_build_query($param);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Log</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $_GET['phone'] ?>">
                <input type="text" placeholder="Từ ngày:" name="from" class="form-control datepicker" value="<?php echo $_GET['from'] ?>">
                <input type="text" placeholder="Đến ngày:" name="to" class="form-control datepicker" value="<?php echo $_GET['to'] ?>">
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
                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                    <th>Số điện thoại</th>
                    <th>Thời gian</th>
                    <th>IP</th>
                    <th>Kênh</th>
                    <th>Trình duyệt</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><input type="checkbox" class="checkitem" name="phone[]" value="<?php echo $item['phone'] ?>" /></td>
                        <td><?php echo $item['phone'] ?></td>
                        <td><?php echo date('d/m/Y H:i:s', $item['datecreate']) ?></td>
                        <td><?php echo $item['ip'] ?></td>
                        <td><?php echo $item['chanel'] ?></td>
                        <td><?php echo $item['useragent'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






