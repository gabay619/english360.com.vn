<?php
// Check login
if($_SESSION['templogin']!=1) {
    header("Location: templogin.php");
    die;
}
?>