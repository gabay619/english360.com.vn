<?php
ob_start();
session_start();
//unset($_SESSION['uinfo']);
session_destroy();
header("Location: index.php");
?>