<?php
if($tact=='popup_insert') include("form.php");
else if($tact=='popup_update') include("form.php");
else if($tact=='popup_delete') include("delete.php");
else if($tact=='popup_reg') include("popupreg.php");
else include("view.php");
?>
