<?php
$title = "Quản lý bài tập viết lại câu - ngữ pháp";
$newscl = $dbmg->nguphap_baitap;
$npid = $_GET['npid'];
//$type = $_GET['type'];
#condition
$limit = 25;
//$cond = array();
$cond = array('npid'=>$npid,'type'=>'nguphap_vietlaicau');
//$cond['type'] = $type;
$sort = array("_id" => -1);
$listnews = $newscl->find($cond)->sort($sort);
//print_r($listnews);
//$rowcount = $cursor->count();
//$listnews = $cursor->skip($cp)->limit($limit);
?>
<title><?php echo $title ?></title>
<ol class="breadcrumb">
    <li><a href="<?php echo cpagerparm("tact,id,status,npid") ?>tact=nguphap_view">Ngữ pháp</a></li>
    <li class="active">Bài tập</li>
</ol>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="text-right row">
    <div class="col-xs-3 text-left">
        <!--<a href="<?php /*echo cpagerparm("tact,id,status") */?>">< Thoát</a> |-->
        <?php if(acceptpermiss("nguphap_test_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=np_vlc_insert"> | Thêm bài tập viết lại câu</a><?php }?>
    </div>
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
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=np_del" method="post">
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
            <th>Tiêu đề</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listnews as $item) { ?>
            <tr>
                <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                <td><?php echo $item['name'] ?>
                    <p class="text-muted">Mã: <?php echo $item['_id'] ?></p>
                </td>
                <td><?php echo date("d-m-Y H:i:s", $item['_id']) ?></td>
                <td>
                    <?php if(acceptpermiss("nguphap_test_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=np_vlc_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                    <?php if(acceptpermiss("nguphap_test_del")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=np_del&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</form>
