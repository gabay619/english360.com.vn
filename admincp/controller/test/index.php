<?php
if($tact=='test_insert') include("form.php");
else if($tact=='test_update') include("form.php");
else if($tact=='test_delete') include("delete.php");
else if($tact=='test_level_view') include("level_view.php");
else if($tact=='test_level_insert') include("level_form.php");
else if($tact=='test_level_update') include("level_form.php");
else if($tact=='test_level_delete') include("level_delete.php");
else include("view.php");
?>
