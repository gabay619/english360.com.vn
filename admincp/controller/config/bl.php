<?php
$title = "Cấu hình BlackList";
$configcl = $dbmg->config;
$blCl = $dbmg->bl;
$cond = array();
if(isset($_GET['phone']) && !empty($_GET['phone'])){
    $searchPhone = $_GET['phone'];
    $rest = substr($searchPhone, 0, 1);
    if ($rest == '0') {
        $searchPhone = substr($searchPhone, 1);
    }
    $cond['phone'] = $searchPhone;
}

#Post Process
if (isset($_POST['submit'])) {
    $phone = $_POST['phone'];
    $rest = substr($phone, 0, 1);
    if ($rest == '0') {
        $phone = substr($phone, 1);
    }
    if(!$blCl->findOne(array('phone'=>$phone))){
        $blCl->insert(array('phone'=>$phone));
    }

    $_SESSION['status'] = 'success';
    header("Location: " . cpagerparm("status"));
    exit();
}
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$cursor = $blCl->find($cond);
$rowcount = $cursor->count();
$listbl = $cursor->skip($cp)->limit($limit);

//print_r($listbl);die;

?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">BlackList</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-5" role="form" action="" method="post">
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại">
                <input type="submit" name="submit" class="btn btn-primary" value="Tạo mới">
            </div>
        </form>
        <form class="form-inline col-sm-5 pull-right" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $_GET['phone'] ?>">
                <input type="submit" class="btn btn-success" value="Tìm">
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                    <th>Số điện thoại</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($listbl as $item) { ?>
                    <tr>
                        <td><input type="checkbox" class="checkitem" name="phone[]" value="<?php echo $item['phone'] ?>" /></td>
                        <td><?php echo $item['phone'] ?></td>
                        <td>
                            <a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=bl_delete&phone=<?php echo $item['phone'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
</div>

<script>
    function getLink(url){
        s=prompt('Xem link:',url)
    }

    function showLink(){
        source = $('#partner-source').val();
        link = $('#partner-link').val();
        cuphap = $('#partner-cuphap').val();
        url = '<?php echo Constant::BASE_URL ?>'+'/ads.php?source='+source+'&link='+link+'&cuphap='+cuphap;
        s=prompt('Link quảng cáo cho đối tác:',url)
    }
</script>






