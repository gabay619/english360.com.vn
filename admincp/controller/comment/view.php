<?php
$title = "Quản lý Comment";
$commentcl = $dbmg->comment;
$usercl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
if(isset($q)){
    $user = $usercl->findOne(array('phone'=>new MongoRegex("/$q/iu")));
    if($user)
        $cond = array(
            '$or'=>array(
                array('content'=>new MongoRegex("/$q/iu")),
                array('uid'=>$user['_id'])
            )
        );
    else
        $cond = array('content'=>new MongoRegex("/$q/iu"));
}
else $cond = array();
$sort = array("datecreate" => -1);
$cursor = $commentcl->find($cond)->sort($sort);
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
                        <input type="text" placeholder="Số điện thoại hoặc nội dung" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
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
                <th>Người tạo</th>
                <th>Nội dung</th>
                <th>Bài học</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listnews as $item) {
                $user = $usercl->findOne(array('_id'=>$item['uid']),array('phone'));
                $lessioncl = Common::getClFromType($item['type']);
                $lessioncl = $dbmg->$lessioncl;
                $lessionItem = $lessioncl->findOne(array('_id'=>$item['objid']), array('name'));
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td><?php echo $user['phone'] ?></td>
                    <td><?php echo $item['content'] ?>
                    <td><?php echo $lessionItem['name']?> <i>(<?php echo Common::getcategorytype($item['type'])['name']?>)</i></td>
                    <td><?php echo date("d-m-Y H:i:s", $item['_id']) ?></td>
                    <td>
                        <?php if(acceptpermiss("comment_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=comment_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>