<?php
$title = "Chi tiết trình độ";
$testcl = $dbmg->test_level;
//$categorycl = $dbmg->category;
//$lnaParentCate = $categorycl->findOne(array('type'=>Constant::TYPE_NGUPHAP, 'parentid'=>'0'));
$id = $_GET['id'];
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
//    if(count($_POST['category'])<=0) $_POST['category'] = array();
    $redirect = $_POST['redirect'];
    $_POST['start'] = intval($_POST['start']);
    $_POST['end'] = intval($_POST['end']);
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    if ($tact == "test_level_insert") {
        $_POST['_id'] = strval(time());
//        $_POST['datecreate'] = time();
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $result = $testcl->insert($_POST);
    }
    else  $result = $testcl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
    exit();
}
##Get Data
if ($tact != "test_level_insert") $_POST = (array)$testcl->findOne(array("_id" => "$id"));
//else{
//    $_POST['category'][] = $lnaParentCate['_id'];
//}
?>
<form class="form-horizontal" role="form" action="" method="post">

    <div class="">
        <div class="" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />

            <div class="form-group">
                <label class="col-sm-2 control-label">Điểm từ</label>

                <div class="col-sm-2">
                    <input type="text" name="start" class="form-control" value="<?php echo $_POST['start'] ?>">
                </div>
                <label class="col-sm-1 control-label">Đến</label>
                <div class="col-sm-2">
                    <input type="text" name="end" class="form-control" value="<?php echo $_POST['end'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên trình độ</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mô tả</label>
                <div class="col-sm-10">
                    <textarea id="content" rows="10" class="form-control" name="content" placeholder="Nhập nội dung bài tập"><?php echo $_POST['content'] ?></textarea>
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
            theme_advanced_buttons3: "tablecontrols,|,template",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,
            apply_source_formatting: true,
            content_css: "plugin/tinymce/tinymce.css",
            external_image_list_url : "plugin/tinymce/myexternallist.js",
            template_external_list_url : "plugin/tinymce/myexternallist.js"
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