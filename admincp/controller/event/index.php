<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
if($tact=='event_delete') include("delete.php");
elseif ($tact=='event_insert' || $tact == 'event_update') include("form.php");
else if($tact=='event1_delete') include("event1_delete.php");
else if($tact == 'event1') include("event1.php");
else if($tact == 'event_user') include("event_user.php");
else if($tact == 'user_delete') include("user_delete.php");
else
include("view.php");
?>
