<?php
$title = "Quản lý Trang";
$pageCl = $dbmg->page;
#condition
$cond = array('status' => Constant::STATUS_ENABLE);
$sort = array("_id" => -1);
$list = $pageCl->find($cond)->sort($sort);
$typeArr = array(
    Constant::TYPE_INFO => 'Giới thiệu',
    Constant::TYPE_TERM => 'Điều khoản',
    Constant::TYPE_CONTACT => 'Liên hệ'
);
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="text-right row">
        <div class="col-xs-3 text-left">
            <?php if(acceptpermiss("page_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=page_insert">Thêm mới trang</a><?php }?>
        </div>
    </div>
    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=page_delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                <th>ID</th>
                <th>Tên trang</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $item) {
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td><?php echo $item['_id'] ?></td>
                    <td><?php echo $typeArr[$item['type']]?></td>
                    <td><?php echo date("d-m-Y H:i:s", $item['_id']) ?></td>
                    <td>
                        <?php if(acceptpermiss("page_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=page_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                        <?php if(acceptpermiss("page_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=page_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>