<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/03/2017
 * Time: 10:15 AM
 */
include "config/init.php";
include "config/connect.php";
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/';
header('Location: '.$redirect);exit;
print_r($_GET);