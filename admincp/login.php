<?php
ob_start();
session_start();
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include("../config/config.php");
include("../config/connect.php");
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
        <?php
        if(!empty($_POST)){
            $userCl = $dbmg->user;
            $roleCl = $dbmg->role;
            $userObject = (array)$userCl->findOne(array("username"=>$_POST['username'], "password"=>encryptpassword($_POST['password'])));
            if ($userObject['_id']) {
                $_SESSION['uinfo'] = $userObject;
                $_SESSION['uinfoadmin'] = $userObject;
                $_SESSION['username'] = $userObject['username'];
                ## Role
                if(count($userObject['role'])<=0) $userObject['role'] = array();
                $lpp = array();
                $_lrole = $roleCl->find(array("_id"=>array('$in'=>$userObject['role'])));
                foreach($_lrole as $_role) $lpp = array_merge($lpp,$_role['permission']);
                if(count($userObject['permission'])>0) $lpp = array_merge($lpp,$userObject['permission']);
                $_SESSION['permission'] =array_unique($lpp);
                header("Location: index.php");die;
            }
            else{
                echo "<p>Sai thông tin đăng nhập</p>";
            }
        }
        ?>
        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="username"
                       placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-default">Đăng nhập</button>
        </form>
    </div>

</div><!-- /.container -->
</body>
</html>
