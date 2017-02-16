<?php
$title = "Nhóm quyền cho người dùng";
$userCl = $dbmg->user;
$roleCl = $dbmg->role;
$id = $_GET['id'];
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $status = $userCl->update(array("_id"=>"$id"),array('$set'=>array('role'=>$_POST['role'])),array("upsert"=>false));
    if ($status) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
}
##Get Data
$_POST = (array)$userCl->findOne(array("_id" => "$id"));
?>
<?php include("component/message.php"); ?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Nhóm quyền cho người dùng</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <table class="table table-hover">
                <thead>
                <tr>
                    <th> Lựa chọn tất cả <input type="checkbox" id="checkallcat" /> </th>
                    <th>Tên nhóm quyền</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $lrole = $roleCl->find()->sort(array("sort"=>1));
                    foreach($lrole as $role){
                        $cl =""; if(in_array($role['_id'],$_POST['role'])) $cl="checked";
                    ?>
                    <tr>
                        <td><input type="checkbox" class="catitem" <?php echo $cl ?> name="role[]" value="<?php echo $role['_id'] ?>" /></td>
                        <td><?php echo $role['name'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('#checkallcat').click(function () {
            if ($(this).is(':checked')) $('.catitem:not(:disabled)').prop('checked', true);
            else $('.catitem:not(:disabled)').prop('checked', false);
        });
    });
</script>