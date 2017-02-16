<?php
ob_start();
session_start();
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include("../config/config.php");
include("../config/connect.php");
if(!isset($_SESSION['admin_config']) || !$_SESSION['admin_config']){
    header("Location: login-lv2.php");
}

$configCl = $dbmg->config;
$config = $configCl->findOne(array('name'=>Constant::CONFIG_AUTH));
$error_mss = '';
if(!$config){
    $token = Common::generateRandomPassword();
    $newConfig = array(
        '_id'=> strval(time()),
        'name' => Constant::CONFIG_AUTH,
        'value' => array(
            'token' => $token
        )
    );
    $configCl->insert($newConfig);
}elseif(!isset($config['value']['token'])){
    $token = Common::generateRandomPassword();
    $configCl->update(array('name'=>Constant::CONFIG_AUTH), array('$set'=> array('value'=>array('token'=>$token))));
}else
    $token = $config['value']['token'];
if(!isset($_POST['submit'])){
    $mssMT = 'Mã xác thực dịch vụ English360 của bạn là: '.$token;
    Network::sentMT('0904589861', 'OTP', $mssMT);
}else{
    $yourToken = $_POST['token'];
    if($yourToken == $token){
        $configCl->update(array('name'=>Constant::CONFIG_AUTH), array('$set'=> array('value'=>array('token'=>null))));
        $_SESSION['admin_token'] = 1;
        header("Location: index.php?act=config");
    }
    else $error_mss = 'Mã xác thực không đúng';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="asset/css/custom.css" rel="stylesheet">
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="starter-template">
        <h2>ĐĂNG NHẬP CẤU HÌNH</h2>
        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="name">Mã xác thực</label>
                <input type="text" class="form-control" id="name" name="token" placeholder="Enter Token">
                <p class="text-danger"><?php echo $error_mss ?></p>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Đăng nhập</button>
        </form>
    </div>
</div><!-- /.container -->
</body>
</html>
