<?php

$title = "Quản lý banner";
$bannercl = $dbmg->banner;
$cond = array();
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$cursor = $bannercl->find($cond);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
$typeArr = array(
    Constant::BANNER_WEB_FOOTER => 'Banner web chân trang',
    Constant::BANNER_WAP_FIXED => 'Banner wap cố định',
    Constant::BANNER_WEB_HEADER => 'Banner web đầu trang',
);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<?php include("component/flash_mss.php"); ?>
<div class="text-right row">
    <div class="col-xs-3 text-left">
        <?php if(acceptpermiss("banner_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=banner_insert">Thêm mới banner</a><?php }?>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=banner_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                    <th>ID</th>
                    <th>Loại</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                        <td><?php echo $item['_id'] ?></td>
                        <td><?php echo $typeArr[$item['type']] ?></td>
                        <td><?php echo $item['status'] == '0' ? 'Ẩn' : 'Hiện' ?></td>
                        <td>
                            <?php if(acceptpermiss("banner_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=banner_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                            <?php if(acceptpermiss("banner_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=banner_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>






