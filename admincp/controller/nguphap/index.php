<?php
if($tact=='nguphap_insert') include("form.php");
else if($tact=='nguphap_update') include("form.php");
else if($tact=='nguphap_delete') include("delete.php");
##Bài tập
else if($tact=='np_ct_view') include("baitap/view_chontu.php");
else if($tact=='np_dt_view') include("baitap/view_dientu.php");
else if($tact=='np_dct_view') include("baitap/view_diencumtu.php");
else if($tact=='np_htc_view') include("baitap/view_hoanthanhcau.php");
else if($tact=='np_ds_view') include("baitap/view_dungsai.php");
else if($tact=='np_vlc_view') include("baitap/view_vietlaicau.php");
else if($tact=='np_vlct_view') include("baitap/view_vietlaicautranh.php");
else if($tact=='np_tn_view') include("baitap/view_tracnghiem.php");
else if($tact=='np_tnt_view') include("baitap/view_tracnghiemtranh.php");
else if($tact=='np_dtt_view') include("baitap/view_dientutranh.php");
else if($tact=='np_gc_view') include("baitap/view_ghepcau.php");
else if($tact=='np_ct_insert' || $tact=='np_ct_update') include("baitap/form_chontu.php");
else if($tact=='np_dt_insert' || $tact=='np_dt_update') include("baitap/form_dientu.php");
else if($tact=='np_dct_insert' || $tact=='np_dct_update') include("baitap/form_diencumtu.php");
else if($tact=='np_htc_insert' || $tact=='np_htc_update') include("baitap/form_hoanthanhcau.php");
else if($tact=='np_ds_insert' || $tact=='np_ds_update') include("baitap/form_dungsai.php");
else if($tact=='np_vlc_insert' || $tact=='np_vlc_update') include("baitap/form_vietlaicau.php");
else if($tact=='np_vlct_insert' || $tact=='np_vlct_update') include("baitap/form_vietlaicautranh.php");
else if($tact=='np_tn_insert' || $tact=='np_tn_update') include("baitap/form_tracnghiem.php");
else if($tact=='np_tnt_insert' || $tact=='np_tnt_update') include("baitap/form_tracnghiemtranh.php");
else if($tact=='np_dtt_insert' || $tact=='np_dtt_update') include("baitap/form_dientutranh.php");
else if($tact=='np_gc_insert' || $tact=='np_gc_update') include("baitap/form_ghepcau.php");
else if($tact=='np_del') include("baitap/delete.php");

else include("view.php");
?>
