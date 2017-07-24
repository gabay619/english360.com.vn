<?php
if($tact=='slide_insert') include("form.php");
else if($tact=='slide_update') include("form.php");
else if($tact=='slide_delete') include("delete.php");
else include("view.php");
?>