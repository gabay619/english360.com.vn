<?php
$title = "Thông tin danh mục";
$categorycl = $dbmg->category;
$id = $_GET['id'];
$pid = $_GET['pid'];
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $_POST['namenoneutf'] = convert_vi_to_en($_POST['name']);
    if ($_POST['parentid'] <= 0) $_POST['parentid'] ="0";
    if ($tact == "addnew") {
        $_POST['_id'] = (string)strtotime("now");
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $result = $categorycl->insert($_POST);
    }
    else  $result = $categorycl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
    $link = cpagerparm("status,id,tact")."status=success";
    header("Location: $link");
}
##Get Data
if ($tact != "addnew") { $_POST = (array) $categorycl->findOne(array("_id" => "$id")); $pid = $_POST['parentid']; }
?>
<form class="form-horizontal" role="form" action="" method="post">
    <input type="hidden" name="acpt" value="1" />
    <div class="form-group">
        <label class="col-sm-2 control-label">Chứa nội dung</label>
        <div class="col-sm-10">
            <select class="form-control" name="type">
                <?php
                foreach ($categorytype as $type) {
                    ?>
                    <option <?php echo $_POST['type']== $type['key']?"selected":"" ?> value="<?php echo $type['key'] ?>"><?php echo $type['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tên danh mục</label>

        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>" placeholder="Nhập tên danh mục">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tiêu đề SEO</label>

        <div class="col-sm-10">
            <input type="text" name="seoname" class="form-control" value="<?php echo $_POST['seoname'] ?>" placeholder="Nhập tiêu đề">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Mô tả ngắn</label>
        <div class="col-sm-10">
            <input type="text" name="captions" class="form-control" value="<?php echo htmlentities($_POST['captions']) ?>" placeholder="Một vài dòng mô tả">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Từ khóa</label>
        <div class="col-sm-10">
            <input type="text" name="keyword" class="form-control" value="<?php echo $_POST['keyword'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Trạng thái</label>
        <div class="col-sm-10">
            <label class="col-md-2"><input type="radio" name="status" <?php echo $_POST['status']==0 ?> value="0">  Ẩn</label>
            <label class="col-md-2"><input type="radio" name="status" <?php echo $_POST['status']==1 || !isset($_POST['status']) ? "checked":"" ?> value="1">  Hiện</label>
        </div>
    </div>
<!--    <div class="form-group">-->
<!--        <label class="col-sm-2 control-label">Tiền tố</label>-->
<!---->
<!--        <div class="col-sm-10">-->
<!--            <input type="text" name="suffix" class="form-control" value="--><?php //echo $_POST['suffix'] ?><!--" placeholder="Bỏ trống nếu cần thiết">-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label class="col-sm-2 control-label">Hậu tố</label>-->
<!---->
<!--        <div class="col-sm-10">-->
<!--            <input type="text" name="prefix" class="form-control" value="--><?php //echo $_POST['prefix'] ?><!--" placeholder="Bỏ trống nếu cần thiết">-->
<!--        </div>-->
<!--    </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label">Thứ tự</label>

        <div class="col-sm-4">
            <input type="text" name="sort" class="form-control" value="<?php echo $_POST['sort'] ?>" placeholder="Bỏ trống nếu không cần thiết">
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" name="avatar" id="avatar" value="<?php echo $_POST['avatar'] ?>" />
        <label class="col-sm-2 control-label">Ảnh đại diện</label>

        <div class="col-sm-10">
            <input type="file" name="file_upload" id="file_upload" />

            <p>
                <img src="<?php echo $_POST['avatar'] ?>" id="previewavatar" style="max-width: 350px;display:<?php echo strlen($_POST['avatar']) > 0 ? "block" : "none"; ?>" />
            </p>

            <!--<p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Khuyến khích ảnh 555x260px)</p>-->
        </div>
    </div>
<!--    <div class="form-group">-->
<!--        <label class="col-sm-2 control-label">Icon APP</label>-->
<!---->
<!--        <div class="col-sm-10">-->
<!--            <input type="text" name="icon" class="form-control" value="--><?php //echo $_POST['icon'] ?><!--">-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <label class="col-sm-2 control-label">Icon class</label>-->
<!---->
<!--        <div class="col-sm-10">-->
<!--            <input type="text" name="iconclass" class="form-control" value="--><?php //echo $_POST['iconclass'] ?><!--">-->
<!--        </div>-->
<!--    </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label">Danh mục cha</label>
        <div class="col-sm-10">
            <select class="form-control" name="parentid">
                <option value="0">Trống</option>
                <?php
                $listcat = iterator_to_array($categorycl->find(array('_id'=>array('$ne'=>"$id")), array("_id", "name")), false);
                if ($listcat == null) $listcat = array();
                foreach ($listcat as $cat) {
                    ?>
                    <option <?php echo $pid== $cat['_id']?"selected":"" ?> value="<?php echo $cat['_id'] ?>"><?php echo $cat['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Chấp nhận</button>
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('#checkallcat').click(function () {
            if ($(this).is(':checked')) $('.catitem:not(:disabled)').prop('checked', true);
            else $('.catitem:not(:disabled)').prop('checked', false);
        });
        setTimeout(function(){
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
            $('#file_upload2').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.mp4;',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#medialink').val(obj.file.path);
                    } else {
                        alert(obj.mss);
                    }
                }
            });
        },100);
    });
</script>
<script>
    $(document).ready(function () {
        $('#lyric, #lyric1').tinymce({
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

        $('input[name=keyword]').tagsinput({
            typeahead: {
                afterSelect: function(val) { this.$element.val(''); },
                source:function(query){
                    return $.post('incoming.php?act=suggestTag', {
                        query: query
                    }, function(data){
                        console.log(data);
                        return data;
                    }, 'json')
                },
            }
        });
        $('input[name=keyword]').on('itemAdded', function (event){
            $.post('incoming.php?act=createTag', {
                tag: event.item
            }, function (re) {

            })
        } )
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