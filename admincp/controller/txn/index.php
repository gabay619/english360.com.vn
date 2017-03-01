<?php
if($tact=='txn_card') include("card.php");
if($tact=='txn_bank') include("bank.php");
if($tact=='txn_cash') include("cash.php");
else include("view.php");
?>
