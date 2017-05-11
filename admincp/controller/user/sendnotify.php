<?php
$title = "Thông tin user";
$userCl = $dbmg->user;
$notifycl = $dbmg->notify;
$id = $_GET['id'];
//print_r($_SESSION['uinfoadmin'])
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
    $_POST['_id'] = "" . strtotime("now");
    $_POST['uid'] = $id;
    $_POST['status'] = "1";
    $_POST['usercreate'] = $_SESSION['uinfoadmin']['_id'];
    $_POST['datecreate'] = time();
    $_POST['type'] = Constant::TYPE_NOTIFY;
    $_POST['mss'] = $_SESSION['uinfoadmin']['displayname'].': '.$_POST['mss'];
    $notifycl->insert($_POST);
    // Send Notify
    /*include_once ('plugin/socketio/socket.io.php');
    $socketio = new SocketIO();
    if ($socketio->send('192.168.10.254',3000, 'sendnotify',json_encode(array("sendto"=>$id,"mss"=>$_POST['mss'])))){
        echo 'we sent the message and disconnected';
    } else {
        echo 'Sorry, we have a mistake :\'(';
    }*/

    header("Location: " . cpagerparm("status,id,tact") . "status=success");
}
?>
<?php include("component/message.php"); ?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Gửi thông báo cho người dùng</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />

            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung</label>

                <div class="col-sm-10">
                    <textarea rows="10" class="form-control" name="mss" placeholder="Nội dung thông báo"><?php echo $_POST['mss'] ?></textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a>
        </div>
    </div>
</form>