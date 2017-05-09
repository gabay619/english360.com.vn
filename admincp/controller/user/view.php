<?php
$title = "Quản lý User";
$userCl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
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
else $cond = array();
$sort = array("datecreate" => -1);
$cursor = $userCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listproduct = $cursor->skip($cp)->limit($limit);
$cpage = $cp;
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="text-right row">
<div class="col-xs-3 text-left">
<?php if(acceptpermiss("user_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=user_insert">Thêm mới</a><?php } ?>
</div>
<div class="col-xs-4 right">
<form action="" method="get">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
          <input type="text" placeholder="Tên/số điện thoại/email" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
        </div>
      </div>
</form>
</div>

</div>
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
<!--        <th>Ảnh</th>-->
        <th>Email</th>
        <th>Ngày tạo</th>
        <th>Thời hạn khóa học</th>
        <th>Thao tác</th>
    </tr>
    </thead> 
    <tbody>    
    <?php foreach ($listproduct as $item) { ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
<!--            <td class="col-md-2"><img src="--><?php //echo $item['priavatar'] ?><!--" class="img-thumbnail" style="max-width: 120px;" /></td>-->
            <td><?php echo $item['email'] ?>
                <p class="text-muted"><?php echo $item['_id'] ?></p>
            </td>
            <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
            <td><?php echo isset($item['pkg_expired']) ? ($item['pkg_expired'] > time() ? date("d-m-Y", $item['pkg_expired']) : 'Hết hạn') : 'Chưa đăng ký' ?></td>
            <td>
                <?php if(acceptpermiss("user_sendmail")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_sendmail&id=<?php echo $item['_id'] ?>">Gửi thư</a> |<?php } ?>
                <?php if(acceptpermiss("user_sendnotify")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_sendnotify&id=<?php echo $item['_id'] ?>">Gửi thông báo</a> |<?php } ?>
                <?php if(acceptpermiss("user_rolegroup_insert")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_rolegroup_insert&id=<?php echo $item['_id'] ?>">Nhóm quyền</a> |<?php } ?>
                <?php if(acceptpermiss("user_rolegroup_permission")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_rolegroup_permission&id=<?php echo $item['_id'] ?>">Quyền riêng</a> |<?php } ?>
                <?php if(acceptpermiss("user_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php } ?>
                <?php if(acceptpermiss("user_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=user_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
<?php include("component/paging.php") ?>