<?php
$title = "Cấu hình popup đăng ký";
$configcl = $dbmg->config;

?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<?php include("component/flash_mss.php"); ?>
<?php

if (isset($_POST['acpt'])) {
    unset($_POST['acpt']);
    $_POST['value']['timeout'] = intval($_POST['value']['timeout']);
    $_POST['value']['number'] = intval($_POST['value']['number']);
    $result = $configcl->update(array("name" => Constant::CONFIG_POPUP_REG), array('$set' => $_POST), array("upsert" => false));
    $_SESSION['status'] = 'success';
    header("Location: " . cpagerparm("status"));
    exit();
}else{
    $item = $configcl->findOne(array('name'=> Constant::CONFIG_POPUP_REG));

    if(!$item){
        $newConf = array(
            '_id' => strval(time()),
            'name' => Constant::CONFIG_POPUP_REG,
            'value' => array(
                'timeout' => 0,
                'number' => 0
            )
        );
        $configcl->insert($newConf);
        $_POST = $newConf;
    }else
        $_POST = $item;
}
?>
<form class="form-horizontal" role="form" action="" method="post">
    <input type="hidden" name="acpt" value="1" />
    <div class="form-group">
        <label class="col-sm-2 control-label">Số lần hiển thị</label>
        <div class="col-sm-10">
            <input type="text" name="value[number]" class="form-control" value="<?php echo $_POST['value']['number'] ?>" placeholder="Số lần">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Thời gian chờ (s)</label>
        <div class="col-sm-10">
            <input type="text" name="value[timeout]" class="form-control" value="<?php echo $_POST['value']['timeout'] ?>" placeholder="Giây">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
        </div>
    </div>
</form>
