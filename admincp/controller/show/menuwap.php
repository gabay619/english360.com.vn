<?php
$title = "Danh sách các chuyên mục hiển thị trên menu (Client - wap)";
$showcl = $dbmg->showcl;
$categorycl = $dbmg->category;
$cursor = (array)$showcl->findOne(array("type"=>"menu"));
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<?php include("component/message.php"); ?>
<?php 
if(!empty($_POST)){
    list($groupname,) = explode("-",$_POST['listcat']);
    $_tmpcat = explode(",",$_POST['listcat']);unset($_POST['listcat']);
    if(count($_POST['category'])<=0) $_POST['category'] = array();
    $data['type'] = "menu";
    $data['_id'] =strtotime("now");
    foreach($_tmpcat as $val) array_push($_POST['category'],$val);
    $data['category'] = array_unique($_POST['category']);
    $showcl->remove(array("type"=>"menu"));
    $showcl->insert($data);
    header("Location: ".cpagerparm("status")."status=success");
}
$_POST = $cursor;
?>
<form class="bs-example bs-example-form" role="form" action="" method="post">
  <div class="row">
     <div class="col-lg-6">
        <div class="input-group">           
           <input type="text" class="form-control" name="listcat" placeholder="Gõ mã của chuyên mục và cách nhau bởi dấu ,">
           <span class="input-group-btn">
              <button class="btn btn-default" type="submit">
                 Lưu                 
              </button>
           </span>
        </div><!-- /input-group -->
     </div><!-- /.col-lg-6 -->
  </div><!-- /.row -->
  <div class="row">
    <ul id="listcat">
      <?php 
        $listid = $_POST['category'];
        if(count($listid)<=0) $listid = array();
        $listcategory = resortarray($categorycl->find(array("_id"=>array('$in'=>$listid))),$listid,"_id");
        foreach($listcategory as $item) echo '<li><label><input type="checkbox" checked value="'.$item['_id'].'" name="category[]" />&nbsp;'.$item['name'].'</label></li>';
      ?>
    </ul>
  </div>
</form>
<script>
$(function() {
$( "#listcat" ).sortable();
$( "#listcat" ).disableSelection();
});
</script>