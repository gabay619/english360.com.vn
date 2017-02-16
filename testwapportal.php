<?php
include "config/init.php";
include "config/connect.php";
$link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
$link_vms = Network::genLinkConfirmVms('E', $link_callback);
die("<script>location.href = '".$link_vms."'</script>");

?>
<!--<a href="--><?php //echo $link_vms?><!--">LINK</a>-->
