<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/03/2017
 * Time: 8:38 AM
 */
include "config/init.php";
header('Content-type: application/json');
$arResponse['type'] = 'text';
$arResponse['status'] = 0;
$arResponse['sms'] = 'That bai. test';
echo json_encode($arResponse);exit;