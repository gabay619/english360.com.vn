<?php
if($tact=='txn_card') include("card.php");
if($tact=='txn_bank') include("bank.php");
else include("view.php");
?>
