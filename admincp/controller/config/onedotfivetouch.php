<?php
$title = "Cấu hình 1.5 chạm";
$configcl = $dbmg->config;
//$partnerCl = $dbmg->partner;
//$condPartner = array();
//$limit = 25;
//$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
//if(isset($_POST['partner_search'])){
//    $name = $_POST['partner_name'];
//    $source = $_POST['partner_source'];
//    $condPartner['name'] = new MongoRegex('/'.$name.'/iu');
//    $condPartner['source'] = new MongoRegex('/'.$name.'/iu');
//}
//$sort = array("datecreate" => -1);
//$cursor = $partnerCl->find($condPartner)->sort($sort);
//$rowcount = $cursor->count();
//$listpartner = $cursor->skip($cp)->limit($limit);
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $result = $configcl->update(array("name" => Constant::CONFIG_1_5TOUCH), array('$set' => $_POST), array("upsert" => false));
    $_SESSION['status'] = 'success';
    header("Location: " . cpagerparm("status") . "tab=info");
    exit();
}
//if (isset($_POST['submit'])) {
//    $_POST['_id'] = strval(time());
//    $_POST['datecreate'] = time();
//    unset($_POST['submit']);
//    $partnerCl->insert($_POST);
//    $_SESSION['status'] = 'success';
//    header("Location: " . cpagerparm("status") . "tab=partner_create");
//    exit();
//}
##Get Data
$itemConf = $configcl->findOne(array("name" => Constant::CONFIG_1_5TOUCH));
if(!$itemConf){
    $newConf = array(
        '_id' => strval(time()),
        'name' => Constant::CONFIG_1_5TOUCH,
        'value' => array(
            'status' => Constant::STATUS_DISABLE,
            'active' => Constant::STATUS_DISABLE,
            'timeout' => 0,
            'waittime' => 0
        )
    );
    $configcl->insert($newConf);
    $_POST = $newConf;
}else
    $_POST = $itemConf;
?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li><a href="#info" role="tab" data-toggle="tab">Cấu hình</a></li>
    <li><a href="#partner_create" role="tab" data-toggle="tab">Tạo link đối tác</a></li>
<!--    <li><a href="#partner" role="tab" data-toggle="tab">Danh sách đối tác</a></li>-->
</ul>

<div class="tab-content">
    <div class="tab-pane" id="info">
        <form class="form-horizontal" role="form" action="" method="post">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <?php
            if(acceptpermiss("config_1t")){
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Trạng thái</label>
                    <div class="col-sm-10">
                        <label>
                            <input type="radio" <?php echo $_POST['value']['status'] == '0' ? 'checked' : ''; ?> value="0" name="value[status]" />&nbsp;Tắt
                        </label> |
                        <label>
                            <input type="radio" <?php echo $_POST['value']['status'] == '1' ? 'checked' : ''; ?> value="1" name="value[status]" /> &nbsp;Bật
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tự động đăng ký khi tắt popup</label>
                    <div class="col-sm-10">
                        <label>
                            <input type="radio" <?php echo $_POST['value']['active'] == '0' ? 'checked' : ''; ?> value="0" name="value[active]" />&nbsp;Tắt
                        </label> |
                        <label>
                            <input type="radio" <?php echo $_POST['value']['active'] == '1' ? 'checked' : ''; ?> value="1" name="value[active]" /> &nbsp;Bật
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Thời gian đợi trước khi hiện popup (s)</label>
                    <div class="col-sm-10">
                        <input type="text" name="value[waittime]" class="form-control" value="<?php echo $_POST['value']['waittime'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Thời gian hiện popup (s)</label>
                    <div class="col-sm-10">
                        <input type="text" name="value[timeout]" class="form-control" value="<?php echo $_POST['value']['timeout'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nội dung</label>
                    <div class="col-sm-10">
                        <textarea name="value[content]" id="" class="form-control" rows="10"><?php echo $_POST['value']['content'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Thông báo cước</label>
                    <div class="col-sm-10">
                        <input type="text" name="value[price]" class="form-control" value="<?php echo $_POST['value']['price'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Chấp nhận</button>
                        hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
    <div class="tab-pane" id="partner_create">
        <p>&nbsp;</p>
        <form class="form-horizontal" role="form" action="" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên đối tác</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mã đối tác</label>
                <div class="col-sm-10">
                    <input id="partner-source" type="text" name="source" class="form-control" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link Redirect</label>
                <div class="col-sm-10">
                    <input id="partner-link" type="text" name="link" class="form-control" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Cú pháp</label>
                <div class="col-sm-10">
                    <input id="partner-cuphap" type="text" name="cuphap" class="form-control" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-danger" onclick="showLink('')" type="button">Get Link</button>
<!--                    <button class="btn btn-success" onclick="showLink(2)" type="button">Get Link (VMS)</button>-->
<!--                    <input type="submit" name="submit" class="btn btn-primary" value="Lưu lại">-->
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function(){
        $('.nav-tabs a[href="#<?php echo $tab ?>"]').tab('show')
    })

    function getLink(url){
        s=prompt('Xem link:',url)
    }

    function showLink(id){
        source = $('#partner-source').val();
        link = $('#partner-link').val();
        cuphap = $('#partner-cuphap').val();
        url = '<?php echo Constant::BASE_URL ?>'+'/ads4.php?source='+source+'&link='+link+'&cuphap='+cuphap;
        s=prompt('Link quảng cáo cho đối tác:',url)
    }
</script>






