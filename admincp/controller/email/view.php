<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/10/2016
 * Time: 10:52 AM
 */
$title = "Quản lý Email";
$emailCl = $dbmg->email_log;
$userCl = $dbmg->user;
$cond = array();
if(isset($_GET['phone'])){
    $user = $userCl->findOne(array('$or'=>array(
        array('phone'=>$_GET['phone']),
        array('username'=>$_GET['phone'])
    )));
    if($user)
        $cond['userid'] = $user['_id'];
    else
        $cond['to'] = $_GET['phone'];
}
if(isset($_GET['action'])){
    $cond['action'] = $_GET['action'];
}

$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $emailCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Lịch sử Email</a></li>
    <li><a href="<?php echo cpagerparm("tact,id") ?>tact=email_user">User đăng ký nhận email</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-5 pull-right" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("phone","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Email/Phone/Username" value="<?php echo $_GET['phone'] ?>">
                <input type="submit" class="btn btn-success" value="Tìm kiếm">
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
<!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>Email</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Hành động</th>
                    <th>Ngày tạo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) {
                    $user = $userCl->findOne(array('_id'=>strval($item['userid'])));
                    $lessionName = '';
//                    print_r($item);
                    if(isset($item['itemid']) && !empty($item['itemid'])){
                        $cl = Common::getClFromType($item['action']);
                        $cl = $dbmg->$cl;
                        $lession = $cl->findOne(array('_id'=>$item['itemid']));
                        if($lession)
                            $lessionName = $lession['name'];
                    }
                    ?>
                    <tr>
                        <td><?php echo isset($item['to']) ? $item['to'] : '' ?></td>
                        <td><?php echo $user && isset($user['username']) ? $user['username'] : '' ?></td>
                        <td><?php echo $user && isset($user['phone']) ? $user['phone'] : '' ?></td>
                        <td><?php echo isset($item['action']) ? HistoryLog::getArr()[$item['action']] : '' ?> (<?php echo $lessionName ?>)</td>
                        <td><?php echo date('d/m/Y H:i:s', $item['datecreate'])?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






