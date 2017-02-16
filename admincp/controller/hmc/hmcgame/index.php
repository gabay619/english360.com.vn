<?php
if($tact=='hmcgame_insert') include("form.php");
else if($tact=='hmcgame_update') include("form.php");
else if($tact=='hmcgame_delete') include("delete.php");
else if($tact=='hmcgame_view') include("view.php");
else include("list.php");
?>
