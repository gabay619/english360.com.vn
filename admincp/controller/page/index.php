<?php
if($tact=='page_insert') include("form.php");
else if($tact=='page_update') include("form.php");
else if($tact=='page_delete') include("delete.php");
else include("view.php");
?>
