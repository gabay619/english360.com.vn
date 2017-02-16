<?php
if($tact=='gtcb_insert') include("form.php");
else if($tact=='gtcb_update') include("form.php");
else if($tact=='gtcb_delete') include("delete.php");
##Luyện nghe
else if($tact=='gtcb_listen_view') include("luyennghe/view.php");
else if($tact=='gtcb_listen_insert') include("luyennghe/form.php");
else if($tact=='gtcb_listen_update') include("luyennghe/form.php");
else if($tact=='gtcb_listen_del') include("luyennghe/delete.php");
## Bài tập
else if($tact=='gtcb_test_view') include("baitap/view.php");
else if($tact=='gtcb_dt_view') include("baitap/view_dientu.php");
else if($tact=='gtcb_sx_view') include("baitap/view_sapxep.php");
else if($tact=='gtcb_gc_view') include("baitap/view_ghepcau.php");
else if($tact=='gtcb_test_insert') include("baitap/form.php");
else if($tact=='gtcb_dt_insert') include("baitap/form_dientu.php");
else if($tact=='gtcb_sx_insert') include("baitap/form_sapxep.php");
else if($tact=='gtcb_gc_insert') include("baitap/form_ghepcau.php");
else if($tact=='gtcb_test_update') include("baitap/form.php");
else if($tact=='gtcb_dt_update') include("baitap/form_dientu.php");
else if($tact=='gtcb_gc_update') include("baitap/form_ghepcau.php");
else if($tact=='gtcb_sx_update') include("baitap/form_sapxep.php");
else if($tact=='gtcb_test_del') include("baitap/delete.php");
else if($tact=='gtcb_sx_del') include("baitap/delete_sapxep.php");
else if($tact=='gtcb_dientu_del') include("baitap/delete_dientu.php");
else include("view.php");
?>

