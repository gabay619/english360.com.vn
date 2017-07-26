<?php
if($tact=='user_insert') include("form.php");
else if($tact=='user_update') include("form.php");
else if($tact=='user_delete') include("delete.php");
else if($tact=='user_rolegroup_insert') include("rolegroup.php");
else if($tact=='user_rolegroup_permission') include("permission.php");
else if($tact=='user_sendnotify') include("sendnotify.php");
else if($tact=='user_sendmail') include("sendmail.php");
else if($tact=='user_chart') include("user_chart.php");
else include("view.php");
?>
