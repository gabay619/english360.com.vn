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
    $status = $userCl->update(array("_id"=>"$id"),array('$set'=>array('permission'=>$_POST['permission'])),array("upsert"=>false));
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