<?php
$title = "Thông tin câu trả lời";
$newscl = $dbmg->faq;
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
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $uinfo = $_SESSION['uinfo'];
    $obj = array("_id" => strtotime("now"), "name"=>$_POST['name'],"content" => $_POST['content'], "status" => "1", "parentid" => $id, "usercreate" => $uinfo['_id'], "datecreate" => strtotime("now"));
    $result = $newscl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
}
if ($tact != "addnew") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin câu trả lời</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung câu trả lời</label>
                <div class="col-sm-10">
                    <textarea id="lyric" rows="10" class="form-control" name="content" placeholder="Nhập nội dung bài viết"><?php echo $_POST['content'] ?></textarea>
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
        $('#lyric').tinymce({
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
            content_css: "plugin/tinymce/tinymce.css"
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