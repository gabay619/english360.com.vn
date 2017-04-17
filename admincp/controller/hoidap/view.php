<?php
$title = "Quản lý câu hỏi";
$usercl = $dbmg->user;
$newscl = $dbmg->faq;
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
$sort = array("_id" => -1);
$cursor = $newscl->find(array("parentid"=>"0"))->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor->skip($cp)->limit($limit);
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="text-right row">

<div class="col-xs-4 right">
<form action="" method="get">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
          <input type="text" placeholder="Tiêu đề hoặc mã" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
        </div>
      </div>
</form>
</div>

</div>
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=hoidap_delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
        <th style="width: 600px">Nội dung</th>
        <th>Ngày tạo</th>
        <th>Người tạo</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>    
    <?php foreach ($listnews as $item) {
        $user = $usercl->findOne(array('_id'=>$item['usercreate']),array('email'));
        ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
            <td><?php echo $item['content'] ?>
               <!-- <p class="text-muted">Mã: <?php /*echo $item['_id'] */?></p>-->
            </td>
            <td><?php echo date("d-m-Y", $item['_id']) ?></td>
            <td><?php echo $user['email'];?></td>
            <td>
                <?php if(acceptpermiss("hoidap_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=hoidap_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                <?php if(acceptpermiss("hoidap_reply")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=hoidap_reply&id=<?php echo $item['_id'] ?>">Trả lời</a> |<?php }?>
                <?php if(acceptpermiss("hoidap_reply")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=hoidap_reply_view&id=<?php echo $item['_id'] ?>">Xem Trả lời</a> |<?php }?>
                <?php if(acceptpermiss("hoidap_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=hoidap_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
<?php include("component/paging.php") ?>