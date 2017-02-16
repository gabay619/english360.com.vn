<?php
if($tact=='hoidap_insert') include("form.php");
else if($tact=='hoidap_update') include("form.php");
else if($tact=='hoidap_reply') include("reply.php");
else if($tact=='hoidap_reply_view') include("reply_view.php");
else if($tact=='reply_update') include("reply_update.php");
else if($tact=='hoidap_delete') include("delete.php");
else include("view.php");
?>
