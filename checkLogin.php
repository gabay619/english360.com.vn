<?php
if(!isset($_SESSION['uinfo'])){
    $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php'); exit;
}