<?php
$title = "Thông tin quyền";
$roleCl = $dbmg->role;
$id = $_GET['id'];

?>
<script type="text/javascript" src="plugin/tinymce/tinymce.min.js"></script>
<link rel="stylesheet" href="asset/css/jquery-ui.css">
<script src="asset/js/jquery-ui.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "addnew") {
        $_POST['_id'] = (string)strtotime("now");
        $_POST['datecreate'] = strtotime("now");
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        if($_POST['sort']<=0) $_POST['sort'] = 999;
        $result = $roleCl->insert($_POST);
    }
    else {
        $result = $roleCl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
    }
    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
}
##Get Data
if ($tact != "addnew") $_POST = (array)$roleCl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin chung</a></li>
    <li><a href="#permission" role="tab" data-toggle="tab">Phân quyền</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="info">
    <p>&nbsp;</p>
    <input type="hidden" name="acpt" value="1" />
    <div class="form-group">
        <label class="col-sm-2 control-label">Tên nhóm quyền</label>

        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>" placeholder="Tên chức vụ">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Vị trí</label>

        <div class="col-sm-10">
            <input type="text" name="sort" class="form-control" value="<?php echo $_POST['sort'] ?>" placeholder="Vị trí">
        </div>
    </div>

</div>
<div class="tab-pane" id="permission">
    <label><input type="checkbox" id="checkallcat" class="con-sm-1" />&nbsp; Chọn tất cả</label>
    <ul>
    <?php
        foreach($module as $m){
            $cl = "";if(in_array($m['key'],$_POST['permission'])) $cl = "checked";
            echo '<li><label><input type="checkbox" class="catitem" '.$cl.' name="permission[]" value="'.$m['key'].'" /> '.$m['name']."</label>";
            echo '<ul>';
            if(isset($m['permission']))
                foreach($m['permission'] as $p) {
                    $cl = "";if(in_array($p['key'],$_POST['permission'])) $cl = "checked";
                    echo '<li><label><input type="checkbox" class="catitem" '.$cl.' name="permission[]" value="'.$p["key"].'" /> '.$p['name'].'</label></li>';
                }
            echo '</ul>';
            echo '</li>';
        }
    ?>
    </ul>
</div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Chấp nhận</button>
        hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a> |
        <label><input type="checkbox" checked="checked" value="1" name="redirect" />&nbsp; Không chuyển hướng sau
                                                                                    khi nhập xong</label>
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
<script>
    $(function () {
        $("#listimage").sortable();
        $("#listimage").disableSelection();
    });
</script>