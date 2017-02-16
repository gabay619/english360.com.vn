<?php
$title = "Cấu hình 1 chạm";
$configcl = $dbmg->config;
$partnerCl = $dbmg->partner;
$condPartner = array();
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
if(isset($_POST['partner_search'])){
    $name = $_POST['partner_name'];
    $source = $_POST['partner_source'];
    $condPartner['name'] = new MongoRegex('/'.$name.'/iu');
    $condPartner['source'] = new MongoRegex('/'.$name.'/iu');
}
$sort = array("datecreate" => -1);
$cursor = $partnerCl->find($condPartner)->sort($sort);
$rowcount = $cursor->count();
$listpartner = $cursor->skip($cp)->limit($limit);
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
    $result = $configcl->update(array("name" => Constant::CONFIG_1TOUCH), array('$set' => $_POST), array("upsert" => false));
    $_SESSION['status'] = 'success';
    header("Location: " . cpagerparm("status") . "tab=info");
    exit();
}
if (isset($_POST['submit'])) {
    $_POST['_id'] = strval(time());
    $_POST['datecreate'] = time();
    unset($_POST['submit']);
    $partnerCl->insert($_POST);
    $_SESSION['status'] = 'success';
    header("Location: " . cpagerparm("status") . "tab=partner_create");
    exit();
}
##Get Data
$itemConf = $configcl->findOne(array("name" => Constant::CONFIG_1TOUCH));
if(!$itemConf){
    $newConf = array(
        '_id' => strval(time()),
        'name' => Constant::CONFIG_1TOUCH,
        'value' => Constant::STATUS_DISABLE
    );
    $configcl->insert($newConf);
    $_POST = $newConf;
}else
$_POST = $itemConf;
?>
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li><a href="#info" role="tab" data-toggle="tab">Cấu hình</a></li>
        <li><a href="#partner_create" role="tab" data-toggle="tab">Tạo link đối tác</a></li>
        <li><a href="#partner" role="tab" data-toggle="tab">Danh sách đối tác</a></li>
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
                            <input type="radio" <?php echo $_POST['value'] == '0' ? 'checked' : ''; ?> value="0" name="value" />&nbsp;Tắt
                        </label> |
                        <label>
                            <input type="radio" <?php echo $_POST['value'] == '1' ? 'checked' : ''; ?> value="1" name="value" /> &nbsp;Bật
                        </label>
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
                        <button class="btn btn-success" onclick="showLink(2)" type="button">Get Link (VMS)</button>
                        <input type="submit" name="submit" class="btn btn-primary" value="Lưu lại">
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="partner">
            <p>&nbsp;</p>
            <form action="<?php echo cpagerparm("status,id,tab") ?>tab=partner" method="post" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" name="partner_name" placeholder="Tên đối tác" value="<?php echo $_POST['partner_name'] ?>">
                    <input type="text" class="form-control" name="partner_source" placeholder="Mã đối tác" value="<?php echo $_POST['partner_source'] ?>">
                    <input type="submit" class="btn btn-primary" value="Tìm" name="partner_search">
                </div>
            </form>
            <form action="<?php echo cpagerparm("tact,id,status") ?>tact=onetouch_delete&tab=partner" method="post">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                        <th>Tên đối tác</th>
                        <th>Mã đối tác</th>
                        <th>Cú pháp</th>
                        <th>Link Redirect</th>
                        <th>Link cho đối tác</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($listpartner as $item) { ?>
                        <tr>
                            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                            <td><?php echo $item['name'] ?></td>
                            <td><?php echo $item['source'] ?></td>
                            <td><?php echo $item['cuphap'] ?></td>
                            <td><a href="javascript:getLink('<?php echo $item['link'] ?>')">XEM LINK</a></td>
                            <td><a href="javascript:getLink('<?php echo Constant::BASE_URL.'/ads.php?source='.$item['source'].'&link='.$item['link'].'&cuphap='.$item['cuphap'] ?>')">XEM LINK</a></td>
                            <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
                            <td>
                                <a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=onetouch_delete&id=<?php echo $item['_id'] ?>">Xóa</a>
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
        url = '<?php echo Constant::BASE_URL ?>'+'/ads'+id+'.php?source='+source+'&link='+link+'&cuphap='+cuphap;
        s=prompt('Link quảng cáo cho đối tác:',url)
    }
</script>






