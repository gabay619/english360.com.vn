<?php
ob_start();
session_start();
if(!empty($_POST)){
    if($_POST['username']=="admin" && $_POST['password']=="lethieniq@123"){
        $_SESSION['admin_config'] = 1;
        header("Location: validate.php");
    }
    else echo "Sai thông tin đăng nhập";
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
                <label for="name">Username</label>
                <input type="text" class="form-control" id="name" name="username" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
    </div>
</div><!-- /.container -->
</body>
</html>
