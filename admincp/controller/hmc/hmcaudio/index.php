<?php
if($tact=='hmcaudio_insert') include("form.php");
else if($tact=='hmcaudio_update') include("form.php");
else if($tact=='hmcaudio_delete') include("delete.php");
else if($tact=='audio_upload_view') include("view_upload.php");
else if($tact=='audio_upload_delete') include("delete_upload.php");
else include("view.php");
?>
