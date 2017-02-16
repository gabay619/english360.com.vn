<?php
$title = "Thông tin popup";
$popupcl = $dbmg->popup;
$id = $_GET['id'];
$loginArr = array(
    '1' => 'Rồi',
    '2' => 'Chưa',
    '3' => 'Cả 2'
);
$verArr = array(
    'web' => 'WEB',
    'wap' => 'WAP',
    'app'=> 'APP',
    'ww' => 'WEB + WAP'
);
?>
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    if(!empty($_POST['start'])){
        $convertStart = DateTime::createFromFormat('d/m/Y', $_POST['start'])->format('Y-m-d');
        $_POST['start'] = (int)strtotime($convertStart);
    }
    if(!empty($_POST['end'])){
        $convertEnd = DateTime::createFromFormat('d/m/Y', $_POST['end'])->format('Y-m-d 23:59:59');
        $_POST['end'] = (int)strtotime($convertEnd);
    }
    $_POST['count_on_day'] = intval($_POST['count_on_day']);
    $_POST['distance_time'] = intval($_POST['distance_time']);
    $_POST['timeout'] = intval($_POST['timeout']);
    if(!empty($_POST['url']))
        $_POST['url'] = explode(',', $_POST['url']);
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "popup_insert") {
        $_POST['_id'] = strval(time());
        $_POST['datecreate'] = time();
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $result = $popupcl->insert($_POST);
    }
    else  $result = $popupcl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    $_SESSION['status'] = 'success';
    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact"));
    else header("Location: " . cpagerparm("status"));
    exit();

}

##Get Data
if ($tact != "popup_insert") $_POST = (array)$popupcl->findOne(array("_id" => "$id"));
else{
    $_POST['start'] = time();
}
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin trang</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>" placeholder="Tên popup">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Trạng thái</label>
                <div class="col-sm-10">
                    <label>
                        <input type="radio" <?php echo isset($_POST['status']) && $_POST['status'] == '0' ? 'checked' : ''; ?> value="0" name="status" />&nbsp;Ẩn
                    </label> |
                    <label>
                        <input type="radio" <?php echo !isset($_POST['status']) || $_POST['status'] == '1' ? 'checked' : ''; ?> value="1" name="status" /> &nbsp;Hiện
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung chi tiết</label>

                <div class="col-sm-10">
                    <textarea id="content" rows="10" class="form-control" name="content" placeholder="Nhập nội dung popup"><?php echo $_POST['content'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bắt đầu</label>
                <div class="col-sm-3">
                    <input type="text" name="start" class="form-control datepicker" value="<?php echo date('d/m/Y', $_POST['start']) ?>" placeholder="Ngày bắt đầu">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Kết thúc</label>
                <div class="col-sm-3">
                    <input type="text" name="end" class="form-control datepicker" value="<?php echo isset($_POST['end']) ? date('d/m/Y', $_POST['end']) : ''?>" placeholder="Ngày kết thúc">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Số lần hiển thị trong ngày</label>
                <div class="col-sm-3">
                    <input type="text" name="count_on_day" class="form-control" value="<?php echo $_POST['count_on_day'] ?>" placeholder="Lần">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Khoảng cách tối thiểu giữa 2 lần hiển thị</label>
                <div class="col-sm-3">
                    <input type="text" name="distance_time" class="form-control" value="<?php echo $_POST['distance_time'] ?>" placeholder="Giây">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Thời gian đợi trước khi hiển thị</label>
                <div class="col-sm-3">
                    <input type="text" name="timeout" class="form-control" value="<?php echo $_POST['timeout'] ?>" placeholder="Giây">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Đã đăng nhập</label>
                <div class="col-sm-3">
                    <select name="login" class="form-control">
                        <?php foreach($loginArr as $k=>$v):?>
                        <option value="<?php echo $k ?>" <?php if($k == $_POST['login']) echo 'selected'?>><?php echo $v?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Hiển thị trên</label>
                <div class="col-sm-3">
                    <select name="ver" class="form-control">
                        <?php foreach($verArr as $k=>$v):?>
                            <option value="<?php echo $k ?>" <?php if($k == $_POST['ver']) echo 'selected'?>><?php echo $v?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Url (WAP,WEB) hoặc mã bài học (APP)</label>
                <div class="col-sm-10">
                    <input type="text" name="url" class="form-control" value="<?php echo implode(',',$_POST['url']) ?>" placeholder="Để trống nếu hiển thị trên toàn bộ site, cách nhau bởi dấu phẩy">
                </div>
            </div>

        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a> |
            <label><input type="checkbox" checked="checked" value="1" name="redirect" />&nbsp; Không chuyển hướng sau
                khi nhập xong</label>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('#content').tinymce({
            script_url: 'plugin/tinymce/tiny_mce.js',
            elements: "ajaxfilemanager",
            theme: "advanced",
            skin: "default",
            width: "100%",
            height: 400,
            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,legacyoutput",
            image_advtab: true,
            file_browser_callback: "ajaxfilemanager",
            theme_advanced_buttons1: "video,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
            theme_advanced_buttons3: "tablecontrols",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,
            apply_source_formatting: true,
            content_css: "plugin/tinymce/tinymce.css",
            external_image_list_url : "plugin/tinymce/myexternallist.js"
        });
    });
    function ajaxfilemanager(field_name, url, type, win) {
        var ajaxfilemanagerurl = "plugin/tinymce/plugins/ajaxfilemanager/ajaxfilemanager.php";
        var view = 'detail';
        switch (type) {
            case "image":
                view = 'thumbnail';
                break;
            case "media":
                break;
            case "flash":
                break;
            case "file":
                break;
            default:
                return false;
        }
        tinyMCE.activeEditor.windowManager.open({
            url: "plugin/tinymce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
            width: 782,
            height: 440,
            inline: "yes",
            close_previous: "no"
        }, {
            window: win,
            input: field_name
        });
    }
</script>