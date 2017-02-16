<?php
$flash_mss = isset($_SESSION['flash_mss']) ? $_SESSION['flash_mss'] : '';
$tpl->assign("flash_mess", $flash_mss);
unset($_SESSION['flash_mss']);

$tpl->assign("pagefile", "home/thong-bao");
include "controller/hmc/index.php";