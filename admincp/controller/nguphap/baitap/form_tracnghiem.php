<?php
$title = "Thông tin bài tập trắc nghiệm - ngữ pháp";
$newscl = $dbmg->nguphap_baitap;
$id = $_GET['id'];
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>tact=np_tn_view ">Trở về danh sách bài tập</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    if ($tact == "np_tn_insert") {
        $_POST['_id'] = (string)strtotime("now");
        $_POST['datecreate'] = time();
        $_POST['type'] = "nguphap_tracnghiem";
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
if ($tact != "np_tn_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin bài tập trắc nghiệm</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <input type="hidden" name="npid" value="<?php echo $_GET['npid'] ?>" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <a href="javascript:void(0)" onclick="addQuestion()">Thêm câu hỏi</a>
                    <p class="help-block">Upload file audio trên /fm rồi paste link vào ô</p>
                </div>
            </div>
            <div class="listaw">
                <?php
                foreach($_POST['question'] as $key=>$item){
                    ?>
                    <div class="form-group" data-order="<?php echo $key?>">
                        <label class="col-sm-2 control-label txtaw">Câu hỏi <?php echo $key+1 ?></label>
                        <div class="col-sm-3">
                            <input type="text" placeholder="Câu hỏi" name="question[<?php echo $key?>][sentence]" class="form-control" value="<?php echo $item['sentence'] ?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" placeholder="Đáp án, cách nhau bởi |" name="question[<?php echo $key?>][list]" class="form-control" value="<?php echo $item['list'] ?>">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" placeholder="ĐA đúng" name="question[<?php echo $key?>][aw]" class="form-control" value="<?php echo $item['aw'] ?>">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Link audio" name="question[<?php echo $key?>][audio]" class="form-control" value="<?php echo $item['audio'] ?>">
                        </div>
                        <div class="col-sm-1">
                            <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>tact=np_tn_view">Thoát</a> |
            <label><input type="checkbox" checked="checked" value="1" name="redirect" />&nbsp; Không chuyển hướng sau
                khi nhập xong</label>
        </div>
    </div>
</form>
<div>
    <button class="btn btn-info" onclick="$(this).parent().find('img').toggle()">Hướng dẫn</button>
    <img src="/admincp/asset/images/nguphap/nguphap_tracnghiem.png" alt="" style="display: none; border: 1px dashed #ccc" >
</div>
<script>
    $(function () {
        $('#file_upload').uploadify({
            'swf': 'plugin/uploadify/uploadify.swf',
            'uploader': 'plugin/uploadify/uploadify.php',
            'onUploadSuccess': function (file, data, response) {
                var obj = JSON.parse(data);
                if (obj.status == 200) {
                    $('#avatar').val(obj.file.path);
                    $('#previewavatar').attr('src', obj.file.path);
                    $('#previewavatar').fadeIn();

                } else {
                    alert(obj.mss);
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#ex').tinymce({
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

    function addQuestion(){
        lastOrder = $('.listaw .form-group:last-child').attr('data-order');
        if(lastOrder == undefined)
            lastOrder = -1;
        next = parseInt(lastOrder)+1;
//        console.log(lastOrder);return false;
        html = '<div class="form-group" data-order="'+next+'">'+
            '<label class="col-sm-2 control-label txtaw">xxx</label>'+
            '<div class="col-sm-3">'+
            '<input type="text" placeholder="Câu hỏi" name="question['+next+'][sentence]" class="form-control">'+
            '</div>'+
            '<div class="col-sm-3">'+
            '<input type="text" placeholder="Đáp án, cách nhau bởi |" name="question['+next+'][list]" class="form-control">'+
            '</div>'+
            '<div class="col-sm-1">'+
            '<input type="text" placeholder="ĐA đúng" name="question['+next+'][aw]" class="form-control">'+
            '</div>'+
            '<div class="col-sm-2">'+
            '<input type="text" placeholder="Link audio" name="question['+next+'][audio]" class="form-control">'+
            '</div>'+
            '<div class="col-sm-1">'+
            '<a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>'+
            '</div>'+
            '</div>';
        $('.listaw').append(html);
        reindexlabel();
    }
    function reindexlabel(){
        var a = $('.listaw .txtaw');
        $.each(a,function(i,v){
            $(this).text("Câu hỏi "+(i+1));
        })
    }
</script>