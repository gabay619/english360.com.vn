<?php
if($tact=='package_insert') include("form.php");
else if($tact=='package_update') include("form.php");
else if($tact=='package_delete') include("delete.php");
else include("view.php");
?>
