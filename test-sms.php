<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/03/2017
 * Time: 8:54 AM
 */
include "config/init.php";
$cuphap = 'MW 1000 E360 NAP '.$_SESSION['uinfo']['_id'];
?>
<a href="sms:9029?body=<?php echo $cuphap ?>">CLICK</a>
