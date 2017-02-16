<?php 
session_start();
?>
<!DOCTYPE HTML>
<html ng-app="filemanager">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="author" content="ViviPro" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Filemanager</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="asset/css/bootstrap-theme.min.css" />
</head>

<body>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }

            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }

            .form-signin .checkbox {
                font-weight: normal;
            }

            .form-signin .form-control {
                position: relative;
                height: auto;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                padding: 10px;
                font-size: 16px;
            }

                .form-signin .form-control:focus {
                    z-index: 2;
                }

            .form-signin input[type="text"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }

            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
    </style>
    <?php
    @session_start();
    unset($_SESSION['uinfoadmin']);
    $err_mss = '';
    if(!empty($_POST['username'])){
        if($_POST['username'] == 'admin1' && $_POST['password'] = '123@123'){
            $_SESSION['uinfoadmin'] = $_POST['username'];
            header('Location: index.php#/explorer');
        }else{
            $err_mss = 'Username hoặc password không đúng.';
        }
    }
    ?>
    <div class="container">

        <form class="form-signin" role="form" method="post">
            <h2 class="form-signin-heading">Login System</h2>
            <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo isset($_POST['username']);?>" required autofocus>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div style="color:red"><?php echo $err_mss;?></div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>

    </div>
</body>
</html>
