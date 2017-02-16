<?php
$title = "Quản lý role";
$roleCl = $dbmg->role;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
if(isset($q)){
    $cond = array(
        '$or'=>array(
                array('namenonutf'=>new MongoRegex("/$q/iu")),
                array('_id'=>"$q")
        )
    );
}
else $cond = array();
$sort = array("sort" => 1);
$cursor = $roleCl->find($cond)->sort($sort);
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
<?php if(acceptpermiss("rolegroup_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=addnew">Thêm mới</a><?php } ?>
</div>
<div class="col-xs-4 right">
<form action="" method="get">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
          <input type="text" placeholder="Tên hoặc mã movie" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
        </div>
      </div>
</div>
</form>
</div>
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
        <th>Mã</th>
        <th>Chức vụ</th>
        <th>Vị trí</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
    </tr>
    </thead> 
    <tbody>    
    <?php foreach ($listproduct as $item) { ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
            <td><?php echo $item['_id'] ?></td>
            <td><?php echo $item['name'] ?>
                <p class="muted-text"><?php echo $item['isstatus'] ?></p>
            </td>
            <td><?php echo $item['sort'] ?></td>
<!--            <td>--><?php //echo $item['quantity'] ?><!--</td>-->
            <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
            <td>
                <?php if(acceptpermiss("rolegroup_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php } ?>
                <?php if(acceptpermiss("rolegroup_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
<?php include("component/paging.php") ?>