<?php
$title = "Quản lý báo cáo vi phạm";
$reportcl = $dbmg->report;
$usercl = $dbmg->user;
$commentcl = $dbmg->comment;
$faqcl = $dbmg->faq;
#condition
$limit = 25;
$p = $_GET['p'];
if($p<=1) $p=1;
$cp = ($p-1)*$limit;
$stpage = $p;

$cond = array();
$sort = array("_id" => -1);
$cursor = $reportcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor->skip($cp)->limit($limit);
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="text-right row">
</div>
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=report_delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
        <th>Người gửi</th>
        <th>Lý do</th>
        <th>Nội dung gốc</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>    
    <?php foreach ($listnews as $item) {
        $user = $usercl->findOne(array('_id'=>$item['uid'] ),array('phone'));
        if($item['type'] == Constant::TYPE_COMMENT){
           $source = $commentcl->findOne(array('_id'=>array('$in'=>array(strval($item['itemid']), intval($item['itemid'])))), array('content'));
        }else{
            $source = $faqcl->findOne(array('_id'=>array('$in'=>array(strval($item['itemid']), intval($item['itemid'])))), array('content'));
        }
        ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
            <td><?php echo $user['phone'] ?></td>
            <td><?php echo $item['content'] ?></td>
            <td><?php echo $source['content'] ?></td>
            <td><?php echo date("d-m-Y H:i:s", $item['_id']) ?></td>
            <td>
                <?php if(acceptpermiss("report_dismiss")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=report_dismiss&id=<?php echo $item['_id'] ?>">Bỏ qua</a><?php }?> |
                <?php if(acceptpermiss("report_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=report_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
<?php include("component/paging.php") ?>