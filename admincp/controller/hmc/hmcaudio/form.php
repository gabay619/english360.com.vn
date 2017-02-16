<?php
$title = "Thông tin nội dung";
$newscl = $dbmg->hmcaudio;
$categorycl = $dbmg->category;
$songParentCate = $categorycl->findOne(array('type'=>Constant::TYPE_SONG, 'parentid'=>'0'));
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
    if(count($_POST['category'])<=0) $_POST['category'] = array();
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    $calendar = $_POST['calendar_date'].' '.$_POST['calendar_time'];
    $convertCalendar = DateTime::createFromFormat('d/m/Y H:i', $calendar)->format('Y-m-d H:i');
    $_POST['calendar'] = (int)strtotime($convertCalendar);
    if($_POST['calendar'] > time()) $_POST['datecreate'] = $_POST['calendar'];
    unset($_POST['calendar_date'],$_POST['calendar_time']);
    if ($tact == "hmcaudio_insert") {
        $_POST['_id'] = strval(time());
        $_POST['datecreate'] = time();
        $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];

        $result = $newscl->insert($_POST);
    }
    else

        $result = $newscl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));

    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
    exit();
}
##Get Data
if ($tact != "hmcaudio_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
else{
    $_POST['category'][] = $songParentCate['_id'];
}
$_POST['calendar'] = isset($_POST['calendar']) ? $_POST['calendar'] : time();

?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin bài hát</a></li>
        <li><a href="#category" role="tab" data-toggle="tab">Chuyên mục</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />

            <div class="form-group">
                <label class="col-sm-2 control-label">Tên bài hát</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Ca sĩ</label>

                <div class="col-sm-10">
                    <input type="text" name="singer" class="form-control" value="<?php echo $_POST['singer'] ?>" placeholder="">
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
                <label class="col-sm-2 control-label">Đặt lịch</label>
                <div class="col-sm-2">
                    <input type="text" name="calendar_date" class="form-control datepicker" value="<?php echo date('d/m/Y', $_POST['calendar'])?>">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="calendar_time" class="form-control timepicker" value="<?php echo date('H:i', $_POST['calendar'])?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link Audio/Video</label>
                <div class="col-sm-10">
                    <input type="text" name="medialink" id="medialink" class="form-control" value="<?php echo $_POST['medialink'] ?>" placeholder="Nhập link Audio">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="file" name="file_upload2" id="file_upload2" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link phụ đề tiếng Anh</label>
                <div class="col-sm-10">
                    <input type="text" name="sub[eng]" id="engsub" class="form-control" value="<?php echo $_POST['sub']['eng'] ?>" placeholder="Nhập link *.vtt">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="file" name="file_upload3" id="file_upload3" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link phụ đề tiếng Việt</label>
                <div class="col-sm-10">
                    <input type="text" name="sub[vie]" id="vietsub" class="form-control" value="<?php echo $_POST['sub']['vie'] ?>" placeholder="Nhập link *.vtt">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="file" name="file_upload4" id="file_upload4" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Link phụ đề song ngữ</label>
                <div class="col-sm-10">
                    <input type="text" name="sub[engvie]" id="engvietsub" class="form-control" value="<?php echo $_POST['sub']['engvie'] ?>" placeholder="Nhập link *.vtt">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="file" name="file_upload5" id="file_upload5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                    <label>
                        <input type="radio" <?php echo !empty($_POST['status']) && $_POST['status'] == '0' ? 'checked' : ''; ?> value="0" name="status" />&nbsp;Ẩn
                    </label> |
                    <label>
                        <input type="radio" <?php echo empty($_POST['status']) || $_POST['status'] == '1' ? 'checked' : ''; ?> value="1" name="status" /> &nbsp;Hiện
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Miễn phí</label>
                <div class="col-sm-10">
                    <label>
                        <input type="radio" <?php echo empty($_POST['free']) || $_POST['free'] == '0' ? 'checked' : ''; ?> value="0" name="free" />&nbsp;Không
                    </label> |
                    <label>
                        <input type="radio" <?php echo !empty($_POST['free']) && $_POST['free'] == '1' ? 'checked' : ''; ?> value="1" name="free" /> &nbsp;Có
                    </label>
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

                    <p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Nên dùng tỉ lệ 6x4)</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Lời bài hát (A-V)</label>
                <div class="col-sm-5" style="padding: 0;">
                    <textarea id="lyric-eng" rows="10" class="form-control" name="contents[eng]" placeholder="Nhập nội dung bài viết"><?php echo $_POST['contents']['eng'] ?></textarea>
                </div>
                <div class="col-sm-5">
                    <textarea id="lyric-vie" rows="10" class="form-control" name="contents[vie]" placeholder="Nhập nội dung bài viết"><?php echo $_POST['contents']['vie'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Từ vựng</label>
                <div class="col-sm-10">
                    <textarea id="lyrictv" rows="10" class="form-control" name="tuvung"><?php echo $_POST['tuvung'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung bài học</label>
                <div class="col-sm-10">
                    <textarea id="lession" rows="10" class="form-control" name="lession" placeholder="Nhập nội dung bài viết"><?php echo $_POST['lession'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bài tập</label>
                <div class="col-sm-10">
                    <textarea id="lyric1" rows="10" class="form-control" name="exam" placeholder="Nhập nội dung bài viết"><?php echo $_POST['exam'] ?></textarea>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="category">
            <label><input type="checkbox" id="checkallcat" class="con-sm-1" />&nbsp; Chọn tất cả</label>
            <?php

            $listselectedcat = $_POST['category'];
            #Đệ quy Category
            function dequy($parentid, $type) {
                global $categorycl, $listselectedcat;
                echo "<ul>";
                //$listcat = iterator_to_array($categorycl->find(array("parentid" => "$parentid", "type" => "$type"), array("_id", "name"))->sort(array("_id" => -1)), false);
                $listcat = iterator_to_array($categorycl->find(array("parentid" => "$parentid", "type"=>"song"), array("_id", "name","type"))->sort(array("_id" => -1)), false);
                foreach ($listcat as $cat) {
                    $id = $cat['_id'];
                    $attr = in_array($id, $listselectedcat) ? "checked" : "";
                    $cl = 'disabled';if($type==$cat['type']) $cl='';
                    echo '<li><label><input '.$cl.' type="checkbox" ' . $attr . ' class="con-sm-1 catitem" name="category[]" value="' . $id . '" />&nbsp;' . $cat['name'] . "</label>";
                    $c = $categorycl->find(array("parentid" => "$id"))->count(); // Kiểm tra xem còn cat con không
                    if ($c > 0) dequy($id, $type); // Nếu còn - tiếp tục đệ quy đến khi hết
                    echo "</li>";
                }
                echo "</ul>";
            }

            dequy("0", "song");

            ?>
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
//                'fileTypeExts': '*.mp3;',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    console.log(obj);
                    if (obj.status == 200) {
                        $('#medialink').val(obj.file.path);
                    } else {
                        alert(obj.mss);
                    }
                }
            });
            $('#file_upload3').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.vtt;',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#engsub').val(obj.file.path);
                    } else {
                        alert(obj.mss);
                    }
                }
            });
            $('#file_upload4').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.vtt;',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#vietsub').val(obj.file.path);
                    } else {
                        alert(obj.mss);
                    }
                }
            });
            $('#file_upload5').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'fileTypeExts': '*.vtt;',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        $('#engvietsub').val(obj.file.path);
                    } else {
                        alert(obj.mss);
                    }
                }
            });
        },100);

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

</script>
<script>
    $(document).ready(function () {
        $('#lyric-eng, #lyric-vie, #lyric1, #lession, #lyrictv').tinymce({
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