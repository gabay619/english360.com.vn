<?php
if($tact=='hssv_import') include("hssv.php");
elseif ($tact=='hssv_view') include("hssv_view.php");
elseif ($tact=='hssv_insert') include("hssv_form.php");
elseif ($tact=='hssv_update') include("hssv_form.php");
elseif ($tact=='hssv_delete') include("hssv_delete.php");
elseif ($tact=='hssv_mt') include("hssv_mt.php");
else include("hssv_view.php");