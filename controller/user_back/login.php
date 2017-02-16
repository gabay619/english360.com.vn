<?php
$usercl = $dbmg->user;
$mes = array('mss'=>"","class"=>"none");
if(!empty($_POST)){
    $phone = $_POST['phone'];
    if(isMobifoneNumber($phone)==0){
        $mes1 = array('mss'=>"Vui lòng nhập số điện thoại mạng Mobifone","class"=>"none");
    }
    $password = encryptpassword($_POST['password']);
    $o = (array) $usercl->findOne(array('phone'=>$phone));
    if(!isset($o)) $o = (array) $usercl->findOne(array('phone'=>$phone));


    if($o['_id']>0&& ($password==$o['password'])){
        $_SESSION['uinfo'] = $o;
        $mgconn->close();
        if(isset($_GET['rd'])) $link = $_GET['rd'];

        else $link = "index.php";
        header("Location: $link");
    }
    if($password != $o['password']){
        $mes2 = array('mss'=>"Sai mật khẩu","class"=>"none");
    }
    else{
        $mes1 = array('mss'=>"Tài khoản không tồn tại trên hệ thống. Xin hãy thử lại","class"=>"none");
    }


}


$tpl->assign("alert1", $mes1);
$tpl->assign("alert2", $mes2);
$tpl->assign("pagefile", "user/login");