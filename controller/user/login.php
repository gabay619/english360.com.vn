<?php
$usercl = $dbmg->user;
$historycl = $dbmg->history_log;

//$max = $_GET['max'];
$mes = array('mss'=>"","class"=>"none");
//$token = new Csrf(true, true, false);
//$tpl->assign("csrf_name", $token->get_token_name());
//$tpl->assign("csrf_value", $token->get_token_value());

$flash_mss = isset($_SESSION['flash_mss']) ? $_SESSION['flash_mss'] : '';
$tpl->assign("flash_mess", $flash_mss);
unset($_SESSION['flash_mss']);

//$token_name = $token->get_token_name();
if(!empty($_POST)){
    if(!isset($_POST['phone'])){
        $mes1 = array('mss'=>"Tên đăng nhập không được để trống.","class"=>"none");
    }
    $phone = $_POST['phone'];
    $phone = strtolower($phone);
//    if(Network::mobifoneNumber($phone)){
        $o = $usercl->findOne(array(
            '$or'=>array(
                array('phone' => $phone),
                array('username' => $phone)
            )
        ));
        if($o){
            $password = encryptpassword($_POST['password']);
            if($o['_id']>0 && ($password==$o['password'])){
                $_SESSION['uinfo'] = $o;
                $newHistoryLog = array(
                    '_id' => strval(time().rand(10,99)),
                    'datecreate' => time(),
                    'action' => HistoryLog::LOG_DANG_NHAP,
                    'chanel' => HistoryLog::CHANEL_WAP,
                    'ip' => Network::ip(),
                    'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
                    'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
                    'status' => Constant::STATUS_ENABLE,
                    'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
                    'price'=>0
                );
                if(!isset($_SESSION['notsave_log']))
                    $historycl->insert($newHistoryLog);

                $mgconn->close();
                //Nếu đang có yêu cầu xác thực email
                if(isset($_SESSION['required_verify_email'])){
                    $verifyEmail = $_SESSION['required_verify_email'];
                    $bodyEmail = '<p>Xin chào,</p>'.
                        '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào link bên dưới</p>'.
                        '<p><a href="'.Common::getVerifyEmailUrl($o['_id'],$verifyEmail).'">'.Common::getVerifyEmailUrl($o['_id'],$verifyEmail).'</a></p>'.
                        '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
                    $mail = new \helpers\Mail($verifyEmail, 'Xác thực email English360.vn', $bodyEmail);
                    $mail->send();
                    unset($_SESSION['required_verify_email']);
                    $_SESSION['flash_mss'] = 'Chúng tôi đã gửi 1 email xác nhận về địa chỉ '.$verifyEmail.', vui lòng xác nhận địa chỉ email này là của bạn.';
                    header('Location: thong-bao.php');exit;
                }
                if(isset($_SESSION['return_url'])) $link = $_SESSION['return_url'];
                else $link = "index.php";
                header("Location: $link");exit;
            }
            else{
                $mes2 = array('mss'=>"Sai mật khẩu","class"=>"none");
            }
        }else{
            $mes1 = array('mss'=>"Tên đăng nhập không tồn tại.","class"=>"none");
        }
//    }else{
//        $mes1 = array('mss'=>"Vui lòng nhập số điện thoại mạng Mobifone","class"=>"none");
//    }
}


$tpl->assign("alert1", $mes1);
$tpl->assign("alert2", $mes2);
$tpl->assign("pagefile", "user/login");
include "controller/hmc/index.php";