<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
if($tact=='thuvien_insert') include("form.php");
else if($tact=='thuvien_update') include("form.php");
else if($tact=='thuvien_delete') include("delete.php");
else if($tact=='thuvien_view') include("view.php");
else include("list.php");
?>
