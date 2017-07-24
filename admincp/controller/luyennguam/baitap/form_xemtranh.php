<?php
$title = "Thông tin bài tập điền từ - luyện ngữ âm";
$newscl = $dbmg->luyennguam_baitap;
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
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>tact=lna_xt_view ">Trở về danh sách bài tập</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    if ($tact == "lna_xt_insert") {
        $_POST['_id'] = (string)strtotime("now");
        $_POST['datecreate'] = (string)strtotime("now");
        $_POST['type'] = "lna_xemtranh";
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $result = $newscl->insert($_POST);
    }
    else  $result = $newscl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    if ($redirect != 1) header("Location: " . cpagerparm("status,id") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
    exit();
}
##Get Data
if ($tact != "lna_xt_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin bài tập xem tranh</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <input type="hidden" name="lnaid" value="<?php echo $_GET['lnaid'] ?>" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mô tả ngắn</label>

                <div class="col-sm-10">
                    <input type="text" name="captions" class="form-control" value="<?php echo $_POST['captions'] ?>" placeholder="Một vài dòng mô tả">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Thứ tự</label>

                <div class="col-sm-10">
                    <input type="text" name="sort" class="form-control" value="<?php echo $_POST['sort'] ?>" placeholder="Nhập thứ tự của bài điền từ">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link Audio</label>
                <div class="col-sm-10">
                    <input type="text" name="medialink" id="medialink" class="form-control" value="<?php echo $_POST['medialink'] ?>" placeholder="Nhập link audio">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                     <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Chọn file...</span>
                         <!-- The file input field used as target for the file upload widget -->
                        <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
                    </span>
<!--                    <input type="file" name="file_upload" id="file_upload" />-->
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link Ảnh</label>
                <div class="col-sm-10">
                    <input type="text" name="avatar" id="avatar" class="form-control" value="<?php echo $_POST['avatar'] ?>" placeholder="Nhập link avatar">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                     <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Chọn file...</span>
                         <!-- The file input field used as target for the file upload widget -->
                        <input id="file_upload2" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
                    </span>
<!--                    <input type="file" name="file_upload2" id="file_upload2" />-->
                    <p>
                        <img src="<?php echo $_POST['avatar'] ?>" id="previewavatar" style="max-width: 350px;display:<?php echo strlen($_POST['avatar']) > 0 ? "block" : "none"; ?>" />
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Đáp án</label>
                <div class="col-sm-10">
                    <input type="text" name="aw" class="form-control" value="<?php echo $_POST['aw'] ?>" placeholder="Nhập đáp án">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Trạng thái</label>
                <div class="col-sm-10">
                    <label>
                        <input type="radio" <?php echo !empty($_POST['status']) && $_POST['status'] == '0' ? 'checked' : ''; ?> value="0" name="status" />&nbsp;Ẩn
                    </label> |
                    <label>
                        <input type="radio" <?php echo empty($_POST['status']) || $_POST['status'] == '1' ? 'checked' : ''; ?> value="1" name="status" /> &nbsp;Hiện
                    </label>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>tact=lna_xt_view">Thoát</a> |
            <label><input type="checkbox" checked="checked" value="1" name="redirect" />&nbsp; Không chuyển hướng sau
                khi nhập xong</label>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('#file_upload').fileupload({
            dataType: 'json',
            maxFileSize: 2000000000,

            done: function (e, data) {
                obj = data.result;
                console.log(obj)
                if (obj.status == 200) {
                    $(this).parent().parent().find('.progress').remove();
                    $('#medialink').val(obj.file.path);

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

        $('#file_upload2').fileupload({
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

//        $('#file_upload').uploadify({
//            'swf': 'plugin/uploadify/uploadify.swf',
//            'uploader': 'plugin/uploadify/uploadify.php',
//            'onUploadSuccess': function (file, data, response) {
//                var obj = JSON.parse(data);
//                if (obj.status == 200) {
//                    $('#medialink').val(obj.file.path);
//                } else {
//                    alert(obj.mss);
//                }
//            }
//        });
//        $('#file_upload2').uploadify({
//            'swf': 'plugin/uploadify/uploadify.swf',
//            'uploader': 'plugin/uploadify/uploadify.php',
//            'onUploadSuccess': function (file, data, response) {
//                var obj = JSON.parse(data);
//                if (obj.status == 200) {
//                    $('#avatar').val(obj.file.path);
//                    $('#previewavatar').attr('src', obj.file.path);
//                    $('#previewavatar').fadeIn();
//
//                } else {
//                    alert(obj.mss);
//                }
//            }
//        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#lyric').tinymce({
            script_url: 'plugin/tinymce/tiny_mce.js',
            elements: "ajaxfilemanager",
            theme: "advanced",
            skin: "default",
            width: "100%",
            height: 400,
            language: 'en',
            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,legacyoutput",
            image_advtab: true,
            file_browser_callback: "ajaxfilemanager",
            theme_advanced_buttons1: "video,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview,|,forecolor,backcolor,removeformat,|,charmap,media,|,emotions,fullscreen",
            theme_advanced_buttons3: "tablecontrols,loa",
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