<?php
if($tact=='addnew') include("form.php");
else if($tact=='update') include("form.php");
else if($tact=='delete') include("delete.php");
else if($tact=='topcate') include("topcate.php");
else include("view.php");
?>
