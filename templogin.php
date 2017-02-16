<?php

//include "config/config.php";
session_start();
if(!empty($_POST)){
    if($_POST['u']=="admin" && $_POST['p']=="tagt123"){
        $_SESSION['templogin'] = 1;
        header("Location: index.php");
    }
    else echo "Sai thông tin đăng nhập";
}
?>
<form method="post" action="">
    <input placeholder="Username" type="text" name="u"><br />
    <input placeholder="Password" name="p" type="password"><br />
    <input type="submit" value="OK">
</form>