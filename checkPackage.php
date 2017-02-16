<?php
if(!isset($_SESSION['uinfo'])){
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php'); exit;
}
if(Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id']) != 1){
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header('Location: regispack.php'); exit;
}