<?php
$title = "Thông tin Slide";
$slidecl = $dbmg->slide;
$id = $_GET['id'];
?>
<!--<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=--><?php //echo strtotime("now") ?><!--"></script>-->
<!--<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />-->
<script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "slide_insert") {
        $_POST['_id'] = strval(time());
        $result = $slidecl->insert($_POST);
    }
    else  $result = $slidecl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    $_SESSION['status'] = 'success';
    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact"));
    else header("Location: " . cpagerparm("status"));
    exit();

}

##Get Data
if ($tact != "slide_insert") $_POST = (array)$slidecl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mô tả ngắn</label>
                <div class="col-sm-10">
                    <input type="text" name="captions" class="form-control" value="<?php echo htmlentities($_POST['captions']) ?>" placeholder="Một vài dòng mô tả">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">URL</label>
                <div class="col-sm-10">
                    <input type="text" name="url" class="form-control" value="<?php echo $_POST['url'] ?>">
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
                <input type="hidden" name="avatar" id="avatar" value="<?php echo $_POST['avatar'] ?>" />
                <label class="col-sm-2 control-label">Ảnh</label>

                <div class="col-sm-10">
<!--                    <input type="file" name="file_upload" id="file_upload" />-->
                    <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Chọn file...</span>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
                    </span>
                    <p>
                        <img src="<?php echo $_POST['avatar'] ?>" id="previewavatar" style="max-width: 350px;display:<?php echo strlen($_POST['avatar']) > 0 ? "block" : "none"; ?>" />
                    </p>
                    <p class="help-block">Chọn ảnh PNG, JPG, JPEG</p>
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

        $('#file_upload').fileupload({
            dataType: 'json',
            maxFileSize: 2000000000,

            done: function (e, data) {
                obj = data.result;
                console.log(obj)
                if (obj.status == 200) {
                    $(this).parent().parent().find('.progress').remove();
                    $('#avatar').val(obj.file.path);
                    $('#previewavatar').attr('src', obj.file.path);
                    $('#previewavatar').fadeIn();
                } else {
                    alert(obj.mss);
                }
            }
        }).on('fileuploadadd', function (e, data) {
            html = '<div class="progress">'+
                '<div class="progress-bar progress-bar-success"></div>'+
                '</div>';
            $(this).parent().parent().append(html);
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            console.log(progress);
            $(this).parent().parent().find('.progress .progress-bar').css(
                'width',
                progress + '%'
            );
        });

//        setTimeout(function() {
//            $('#file_upload').uploadify({
//                'swf': 'plugin/uploadify/uploadify.swf',
//                'uploader': 'plugin/uploadify/uploadify.php',
//                'onUploadSuccess': function (file, data, response) {
//                    var obj = JSON.parse(data);
//                    if (obj.status == 200) {
//                        $('#avatar').val(obj.file.path);
//                        $('#previewavatar').attr('src', obj.file.path);
//                        $('#previewavatar').fadeIn();
//
//                    } else {
//                        alert(obj.mss);
//                    }
//                }
//            });
//        })

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