<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.54.128.164)(PORT = 8080)))(CONNECT_DATA=(SID=eng)))" ;

if($c = OCILogon("vascms", "vascmsEng360", $db))
{
    echo "Successfully connected to Oracle.\n";
        OCILogoff($c);
    }
else
{
    $err = OCIError();
    echo "Connection failed." . $err[text];
    }
?>