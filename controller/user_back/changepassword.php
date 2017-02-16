<?php
$usercl = $dbmg->user;
$usercl = $dbmg->user;
$dtr['status'] = 404;
if (isset($_SESSION['uinfo'])) {
    $lackInfor = !isset($_POST['current_pass']) || !isset($_POST['new_pass']);
    if (!$lackInfor) {
        if ($_POST['new_pass'] === $_POST['re_new_pass']) {
            $currentPass = encryptpassword($_POST['current_pass']);
            $_SESSION['uinfo'] = (object) $_SESSION['uinfo'];
            if ($_SESSION['uinfo']['password'] === $currentPass) {
                $authenticate = true;
            } else {
                /*$soap = new SoapClient($linkChargeService);
                $soapResult = $soap->GetPassword(array("password" => $_POST['current_pass']));
                $currentPass = $soapResult->GetPasswordResult;*/
                if ($_SESSION['uinfo']['password'] === $currentPass) {
                    $authenticate = true;
                }
            }
            if ($authenticate) {
                $criteria = array('_id' => $_SESSION['uinfo']['id'], 'password' => $currentPass);
                $updateInfo = array('password' => encryptpassword($_POST['new_pass']));
                $res = $usercl->update($criteria, array('$set' => ($updateInfo)));
                if ($res["updatedExisting"] === true) {
                    $dtr['status'] = 200;
                    unset($userinfo->password);
                    // Send SMS include new passowrd for user
                    $dtr['mss'] = "Mật khẩu được đổi thành công";
                    $dtr['data'] = $userinfo;
                }
            } else {
                $dtr['mss'] = "Bạn nhập sai mật khẩu hiện thời";
            }
        } else {
            $dtr['mss'] = 'Mật khẩu nhập vào không khớp. Vui lòng xem lại';
        }
    } else {
        $dtr['mss'] = 'Cần điền đầy đủ thông tin';
    }
} else {
    $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này';
}
echo json_encode($dtr);
$tpl->assign("alert", $mes);
$tpl->assign("pagefile", "user/changepassword");
?>