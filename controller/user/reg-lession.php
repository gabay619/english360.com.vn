<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$userCl = $dbmg->user;
include '/checkLogin.php';

$user = $userCl->findOne(array('_id' => $_SESSION['uinfo']['_id']));
$allType = Common::getAllLessionType();
$checked = isset($user['reg_lession']) ? $user['reg_lession'] : array();
$email = isset($user['email']) ? $user['email'] : '';
$showEmail = (empty($email) || count($checked) ==0) && !isset($_SESSION['reg_lession_popup']);
$tpl->assign("allType", $allType);
$tpl->assign("checked", $checked);
$tpl->assign("showEmail", $showEmail);
$tpl->assign("email", $email);
$tpl->assign("pagefile", "user/reg-lession");


include "controller/hmc/index.php";
?>