<?php
if($tact=='luyennguam_insert') include("form.php");
else if($tact=='luyennguam_update') include("form.php");
else if($tact=='luyennguam_delete') include("delete.php");
##Bài tập
else if($tact=='lna_tn_view') include("baitap/view_tracnghiem.php");
else if($tact=='lna_dt_view') include("baitap/view_dientu.php");
else if($tact=='lna_dc_view') include("baitap/view_dienchu.php");
else if($tact=='lna_pa_view') include("baitap/view_phatam.php");
else if($tact=='lna_xt_view') include("baitap/view_xemtranh.php");
else if($tact=='lna_tn_insert' || $tact=='lna_tn_update') include("baitap/form_tracnghiem.php");
else if($tact=='lna_dt_insert' || $tact=='lna_dt_update') include("baitap/form_dientu.php");
else if($tact=='lna_dc_insert' || $tact=='lna_dc_update') include("baitap/form_dienchu.php");
else if($tact=='lna_pa_insert' || $tact=='lna_pa_update') include("baitap/form_phatam.php");
else if($tact=='lna_xt_insert' || $tact=='lna_xt_update') include("baitap/form_xemtranh.php");
else if($tact=='lna_del') include("baitap/delete.php");

else include("view.php");
?>
