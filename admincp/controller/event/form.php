<?php
$title = "Thông tin Event";
$eventcl = $dbmg->event;
$id = $_GET['id'];
//$loginArr = array(
//    '1' => 'Rồi',
//    '2' => 'Chưa',
//    '3' => 'Cả 2'
//);
//$verArr = array(
//    'web' => 'WEB',
//    'wap' => 'WAP',
//    'app'=> 'APP',
//    'ww' => 'WEB + WAP'
//);
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
    $redirect = $_POST['redirect'];
    if(!empty($_POST['start'])){
        $convertStart = DateTime::createFromFormat('d/m/Y', $_POST['start'])->format('Y-m-d');
        $_POST['start'] = (int)strtotime($convertStart);
    }
    if(!empty($_POST['end'])){
        $convertEnd = DateTime::createFromFormat('d/m/Y', $_POST['end'])->format('Y-m-d 23:59:59');
        $_POST['end'] = (int)strtotime($convertEnd);
    }
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "event_insert") {
        $_POST['_id'] = strval(time());
        $_POST['datecreate'] = time();
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $result = $eventcl->insert($_POST);
    }
    else  $result = $eventcl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    $_SESSION['status'] = 'success';
    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact"));
    else header("Location: " . cpagerparm("status"));
    exit();

}

##Get Data
if ($tact != "event_insert") $_POST = (array)$eventcl->findOne(array("_id" => "$id"));
else{
    $_POST['start'] = time();
}
?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin event</a></li>
    <?php if ($tact != "event_insert"): ?>
        <li><a href="#getlink" role="tab" data-toggle="tab">Tạo link quảng cáo</a></li>
    <?php endif;?>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="info">
<form class="form-horizontal" role="form" action="" method="post">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>" placeholder="Tên Event">
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
                <label class="col-sm-2 control-label">Số ngày miễn phí</label>
                <div class="col-sm-3">
                    <input type="text" name="free_day" class="form-control" value="<?php echo $_POST['free_day'] ?>" placeholder="Nhập số ngày">
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="bgWap" id="bgWap" value="<?php echo $_POST['bgWap'] ?>" />
                <label class="col-sm-2 control-label">Ảnh nền popup Wap</label>

                <div class="col-sm-10">
                    <input type="file" name="file_upload1" id="file_upload1" />

                    <p>
                        <img src="<?php echo $_POST['bgWap'] ?>" id="previewbgWap" style="max-width: 350px;display:<?php echo strlen($_POST['bgWap']) > 0 ? "block" : "none"; ?>" />
                    </p>

<!--                    <p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Nên dùng tỉ lệ 6x4)</p>-->
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="bgWeb" id="bgWeb" value="<?php echo $_POST['bgWeb'] ?>" />
                <label class="col-sm-2 control-label">Ảnh nền popup Web</label>

                <div class="col-sm-10">
                    <input type="file" name="file_upload2" id="file_upload2" />

                    <p>
                        <img src="<?php echo $_POST['bgWeb'] ?>" id="previewbgWeb" style="max-width: 350px;display:<?php echo strlen($_POST['bgWeb']) > 0 ? "block" : "none"; ?>" />
                    </p>

                    <!--                    <p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Nên dùng tỉ lệ 6x4)</p>-->
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Thời gian trước khi hiển thị popup</label>
                <div class="col-sm-3">
                    <input type="text" name="timeout_popup" class="form-control" value="<?php echo $_POST['timeout_popup'] ?>" placeholder="Nhập số giây">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung SMS khi DK</label>
                <div class="col-sm-10">
                    <textarea id="contentMT" rows="10" class="form-control" name="contentMT" placeholder="Nhập nội dung sms"><?php echo $_POST['contentMT'] ?></textarea>
                    <p class="help-block">Dùng {start} thay cho ngày bắt đầu, {end} thay cho ngày kết thúc ưu đãi, {phone} cho sdt, {pass} cho mật khẩu</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung SMS định kỳ</label>
                <div class="col-sm-10">
                    <textarea id="dailyMT" rows="10" class="form-control" name="dailyMT" placeholder="Nhập nội dung sms"><?php echo $_POST['dailyMT'] ?></textarea>
                    <p class="help-block">Dùng {start} thay cho ngày bắt đầu, {end} thay cho ngày kết thúc ưu đãi, {phone} cho sdt, {pass} cho mật khẩu</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung Email khi DK</label>
                <div class="col-sm-10">
                    <textarea id="contentEmail" rows="10" class="form-control" name="contentEmail" placeholder="Nhập nội dung email"><?php echo $_POST['contentEmail'] ?></textarea>
                    <p class="help-block">Dùng {start} thay cho ngày bắt đầu, {end} thay cho ngày kết thúc ưu đãi, {username} cho tên đăng nhập, {pass} cho mật khẩu</p>
                </div>
            </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Nội dung Email định kỳ</label>
            <div class="col-sm-10">
                <textarea id="dailyEmail" rows="10" class="form-control" name="dailyEmail" placeholder="Nhập nội dung email"><?php echo $_POST['dailyEmail'] ?></textarea>
                <p class="help-block">Dùng {start} thay cho ngày bắt đầu, {end} thay cho ngày kết thúc ưu đãi, {username} cho tên đăng nhập, {pass} cho mật khẩu</p>
            </div>
        </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bắt đầu</label>
                <div class="col-sm-3">
                    <input type="text" name="start" class="form-control datepicker" value="<?php echo isset($_POST['start']) ? date('d/m/Y', $_POST['start']) : date('d/m/Y') ?>" placeholder="Ngày bắt đầu">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Kết thúc</label>
                <div class="col-sm-3">
                    <input type="text" name="end" class="form-control datepicker" value="<?php echo isset($_POST['end']) ? date('d/m/Y', $_POST['end']) : ''?>" placeholder="Ngày kết thúc">
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
</div>
<?php if ($tact != "event_insert"): ?>
    <div class="tab-pane" id="getlink">
        <form class="form-horizontal" role="form" action="" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Link</label>
                <div class="col-sm-10">
                    <input type="text" id="link" class="form-control" placeholder="URL redirect">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nguồn</label>
                <div class="col-sm-10">
                    <input type="text" id="source" class="form-control" placeholder="nguồn">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="getLink()">GetLink</button>
            </div>
        </form>
    </div>
    <script>
        function getLink() {
            link = $('#link').val();
            source = $('#source').val();
            url = '<?php echo Constant::BASE_URL ?>'+'/ads5.php?eid=<?php echo $_POST['_id'] ?>&source='+source+'&link='+link;
            s=prompt('Link quảng cáo cho event:',url)
        }
    </script>
<?php endif; ?>
</div>
<script>
    $(document).ready(function () {
        setTimeout(function(){
            $('#file_upload1').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.jpg;*.png',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#bgWap').val(obj.file.path);
                        $('#previewbgWap').attr('src', obj.file.path);
                        $('#previewbgWap').fadeIn();

                    } else {
                        alert(obj.mss);
                    }
                }
            });
            $('#file_upload2').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.jpg;*.png',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#bgWeb').val(obj.file.path);
                        $('#previewbgWeb').attr('src', obj.file.path);
                        $('#previewbgWeb').fadeIn();
                    } else {
                        alert(obj.mss);
                    }
                }
            });
        },100);

        $('#contentEmail').tinymce({
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