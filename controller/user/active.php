<?php
$usercl = $dbmg->user;
$mes = array('mss'=>"","class"=>"none");
if(!empty($_POST)){
    $querry = array("phone"=>$_POST['phone']);
    $userobj = (object) $usercl->findOne($querry);
    if ($userobj->_id){
        if ($userobj->activecode=== $_POST['activecode']){ // Người dùng nhập đúng  mã active
            $usercl->update($querry, array('$set'=>array("status"=>1,"is_active"=>1)), array("multiple"=>false));
            $_SESSION['uinfo'] = (array) $userobj;
            $mes = array('mss'=>"Kích hoạt thành công".'<p><a href="index.php">Quay lại trang chủ</a></p>',"class"=>"");
        }
        else $mes = array('mss'=>'Nhập sai mã xác thực. Vui lòng thử lại.',"class"=>""); // Nếu nhập sai mã
    }
    else  $mes = array('mss'=>'Không có người dùng với số điện thoại này',"class"=>""); // Nếu Số điện thoại chưa được đăng ký trên hệ thống
}
else {
    $_POST['phone'] = $_SESSION['activephone'];
    if($_GET['p']=="reactive")$mes = array('mss'=>"Tài khoản của bạn chưa được xác thực. Vui lòng nhập lại mã xác thực vào đây","class"=>"");
    else $mes = array('mss'=>"Bạn cần nhập đầy đủ thông tin","class"=>"none");
}

$tpl->assign("alert",$mes);
$tpl->assign("POST",$_POST);
$tpl->assign("pagefile", "user/active");
include "controller/hmc/index.php";
?>