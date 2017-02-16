<?php
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 5/23/2016
 * Time: 8:34 AM
 */
session_start();
$ver = isset($_GET['v']) ? $_GET['v'] : 'web';
$_SESSION['version'] = $ver;
header('Location: /');