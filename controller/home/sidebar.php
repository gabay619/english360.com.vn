<?php
##Load Count Sidebar
$notifycl = $dbmg->notify;
if (isset($_SESSION['uinfo'])) {
    $ui = $_SESSION['uinfo'];

##Select Count Notify + Mail
    $tabbarinfo = array(
        "notifycount" => $notifycl->count(array("uid" => $ui['_id'], "status" => "1", "type" => "notify")),
        "mailcount" => $notifycl->count(array("uid" => $ui['_id'], "status" => "1", "type" => "mail")));
    $tpl->assign("tabbarinfo", $tabbarinfo);
}
?>