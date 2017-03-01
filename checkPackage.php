<?php
if(!isset($_SESSION['uinfo'])){
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php'); exit;
}
if(Common::isRegPackage($_SESSION['uinfo']['_id'])){
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header('Location: regispack.php'); exit;
}