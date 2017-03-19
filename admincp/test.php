<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/03/2017
 * Time: 5:32 PM
 */
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
print_r($_SESSION);