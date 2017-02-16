<?php
$title = "Danh sách audio do user upload";
$uploadCl = $dbmg->upload;
$usercl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array('type'=>Constant::TYPE_SONG, 'itemid'=>$_GET['hmcaudioid']);
$sort = array("datecreate" => -1);
$cursor = $uploadCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listUpload = $cursor->skip($cp)->limit($limit);
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="text-right row">

    </div>
    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=audio_upload_delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                <th>Upload bởi</th>
                <th>Link</th>
                <th>Thời gian</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listUpload as $item) {
                $user = $usercl->findOne(array('_id'=>$item['uid']),array('phone'));
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td class="col-md-2"><?php echo $user['phone'] ?></td>
                    <td><?php echo $item['path'] ?></td>
                    <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
                    <td>
                        <?php if(acceptpermiss("audio_upload_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=audio_upload_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>