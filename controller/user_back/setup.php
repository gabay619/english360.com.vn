<?php
$notifycl = $dbmg->notify;
$ui = $_SESSION['uinfo'];
$uid = $ui['_id'];
$t = $_GET['t'];if(!isset($t)) $t="home";
if (isset($_SESSION['uinfo'])) {
if(!empty($_POST)){
//    $lackInfor = !isset($_POST['password']) || !isset($_POST['repassword']);
//    print_r($_POST['password']);
//    print_r($_POST['repassword']);
//    print_r($lackInfor);die;
    $usercl = $dbmg->user;
    $_POST['dob'] = strtotime($_POST['dob']);
    $oldPassword = encryptpassword($_POST['oldpassword']);
    $password = encryptpassword($_POST['password']);
    $reNewPassword = encryptpassword($_POST['repassword']);
    $lackInfor  = !isset($reNewPassword) || !isset($newPassword);
    $_POST['cmtnd_ngaycap'] = strtotime($_POST['cmtnd_ngaycap']);
    if(isset($_FILES['file_upload'])){
        $targetfolder = "uploads/";
        $targetfolder = $targetfolder . basename( $_FILES['file_upload']['name']) ;
        if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetfolder))
        {
//               echo "The file ". basename( $_FILES['file_upload']['name']). " is uploaded";
            $_POST['priavatar'] = $targetfolder;
        }
        else {
//               echo "Problem uploading file";
        }
    }
    $o = (array) $usercl->findOne(array('password'=>$oldPassword));
        if (isset($password) && isset($reNewPassword)) {
//            print_r($o['password']);
//            echo "</br>";
//            print_r($oldPassword);die;
            if($password == $reNewPassword){
                if ($o['password']==$oldPassword){
                    $authenticate = 1;
                }
                else $authenticate=='2';

            }else{
                $messageinfo = array("mss"=>"Mật khẩu nhập vào không khớp. Vui lòng xem lại","display"=>"");
                $tpl->assign("messageinfo",$messageinfo);
            }
        }else{
            $messageinfo = array("mss"=>"Cần điền đầy đủ thông tin","display"=>"");
            $tpl->assign("messageinfo",$messageinfo);
        }



    if($authenticate==1){
            $usercl->update(array("_id"=>$uid),array('$set'=>$_POST),array("multiple"=>false));
            $ui = (array)$usercl->findOne(array("_id"=>$uid));
            $_SESSION['uinfo'] = $ui;
            $messageinfo = array("mss"=>"Cập nhật thông tin thành công","display"=>"");
            $tpl->assign("messageinfo",$messageinfo);
    }
}
}else{
    $messageinfo = array("mss"=>"Bạn cần đăng nhập để thực hiện chức năng này","display"=>"");
    $tpl->assign("messageinfo",$messageinfo);
}
$ui['dob'] = date("d-m-Y",$ui['dob']);
$ui['cmtnd_ngaycap'] = date("d-m-Y",$ui['cmtnd_ngaycap']);
$tpl->assign("alert", $messageinfo);
$tpl->assign("uinfo",$ui);
$tpl->assign("pagefile", "user/setup");
?>