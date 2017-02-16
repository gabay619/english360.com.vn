<?php
$title = "Quản lý popup";
$popupcl = $dbmg->popup;
$cond = array();
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $popupcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<?php include("component/flash_mss.php"); ?>
<div class="text-right row">
    <div class="col-xs-3 text-left">
        <?php if(acceptpermiss("popup_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=popup_insert">Thêm mới popup</a><?php }?>
    </div>
    <div class="col-xs-3 text-left">
        <?php if(acceptpermiss("popup_reg")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=popup_reg">Cấu hình popup Đăng ký</a><?php }?>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=popup_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                    <th>ID</th>
                    <th>Tên popup</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                        <td><?php echo $item['_id'] ?></td>
                        <td><?php echo $item['name'] ?></td>
                        <td><?php echo date('d/m/Y', $item['start']) ?> - <?php echo date('d/m/Y', $item['end']) ?></td>
                        <td><?php echo $item['status'] == '0' ? 'Ẩn' : 'Hiện' ?></td>
                        <td>
                            <?php if(acceptpermiss("popup_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=popup_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                            <?php if(acceptpermiss("popup_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=popup_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






