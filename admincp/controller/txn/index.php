<?php
if($tact=='txn_card') include("card.php");
if($tact=='txn_bank') include("bank.php");
if($tact=='txn_cash') include("cash.php");
if($tact=='txn_sms') include("sms.php");
if($tact=='txn_otp') include("otp.php");
else include("view.php");
?>
