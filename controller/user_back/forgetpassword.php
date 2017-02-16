<?php
$usercl = $dbmg->user;
$mes = array('mss'=>"","class"=>"none");
if(!empty($_POST)){
    $username = $_POST['username'];
    $password = encryptpassword($_POST['password']);
    $o = (array) $usercl->findOne(array('username'=>$username, 'password'=>$password));
    if(!isset($o)) $o = (array) $usercl->findOne(array('phone'=>$username, 'password'=>$password));
    if($o['_id']>0){
        if ($o['status'] != 0) {
            ## Set thoong tin ban đầu
            if(strlen($o['displayname'])<=0) $o['displayname'] = $o['fullname']; // Nếu không có displayname thì set displayname = fullname
            if(strlen($o['displayname'])<=0) $o['displayname'] = $o['phone']; // Nếu không có displayname thì set displayname = Phone
            if(strlen($o['displayname'])<=0) $o['displayname'] = $o['username'];  // Nếu không có displayname thì set displayname = Username

            $_SESSION['uinfo'] = $o;
            $mgconn->close();
            if(isset($_GET['rd'])) $link = $_GET['rd'];
            else $link = "index.php";
            header("Location: $link");
        } else { // Kiểm tra xem tài khoản đã đc active chưa. Nếu chưa đưa người dùng về trang active
            $_SESSION['activephone'] = $o['phone'];
            $mgconn->close();
            header("Location: /active.php?p=reactive");
        }

    }
    else {
        unset($mes);
        $mes = array('mss'=>"Tài khoản không tồn tại trên hệ thống. Xin hãy thử lại","class"=>"");
    }
}
$tpl->assign("alert", $mes);
$tpl->assign("pagefile", "user/forgetpassword");
?>