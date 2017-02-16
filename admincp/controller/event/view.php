<?php
$title = "Quản lý Event";
$eventcl = $dbmg->event;
//$freecl = $dbmg->free_user;
//$userCl = $dbmg->user;
//$configCl = $dbmg->config;
$cond = array();
//if(isset($_GET['phone'])){
//    $searchPhone = $_GET['phone'];
//    $cond['phone'] = $searchPhone;
//}

$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("_id" => -1);
$cursor = $eventcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
//print_r(Network::sentMT('01262169297','TEST','test'));
//print_r(Network::sentMT('0903275310','TEST','test'));
//print_r(Network::sentMT('0936082061','TEST','test'));
//die;
//print_r($listbl);die;

?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Danh sách Event</a></li>
<!--    <li><a href="#config" role="tab" data-toggle="tab">Cấu hình</a></li>-->
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-5" role="form" action="" method="post">
            <div class="form-group">
<!--                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" id="txtNewPhone">-->
                <a class="btn btn-primary" href="<?php echo cpagerparm("tact,id,status") ?>tact=event_insert" type="button">Tạo mới</a>
<!--                <button class="btn btn-danger" onclick="deleteAll();" type="button">Xóa hết</button>-->
            </div>
        </form>

<!--        <form class="form-inline col-sm-5 pull-right" role="form" action="" method="get">-->
<!--            --><?php //foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?><!-- <input type="hidden" name="--><?php //echo $key ?><!--" value="--><?php //echo $val ?><!--" /> --><?php //} ?>
<!--            <div class="form-group">-->
<!--                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="--><?php //echo $_GET['phone'] ?><!--">-->
<!--                <input type="submit" class="btn btn-success" value="Tìm kiếm">-->
<!--            </div>-->
<!--        </form>-->
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=event_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
<!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>ID</th>
                    <th>Tên event</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
<!--                        <td><input type="checkbox" class="checkitem" name="phone[]" value="--><?php //echo $item['phone'] ?><!--" /></td>-->
                        <td><?php echo $item['_id'] ?></td>
                        <td><?php echo $item['name'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="<?php echo cpagerparm("tact,status,id") ?>tact=event_update&id=<?php echo $item['_id'] ?>">Sửa</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=event_delete&id=<?php echo $item['_id'] ?>">Xóa</a>
                            <a class="btn btn-primary btn-sm" href="<?php echo cpagerparm("tact,status,id") ?>tact=event_user&eid=<?php echo $item['_id'] ?>">Danh sách user</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>

<!--    <div class="tab-pane" id="config">-->
<!--        <form class="form-horizontal" role="form" action="" method="post">-->
<!--            <div class="form-group">-->
<!--                <label class="col-sm-2 control-label">Số ngày miễn phí</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <input type="text" name="freeday" class="form-control">-->
<!--                </div>-->
<!--                <input name="submit" class="btn btn-default" value="OK"/>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
</div>






