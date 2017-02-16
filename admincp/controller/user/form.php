<?php
$title = "Thông tin user";
$userCl = $dbmg->user;
$id = $_GET['id'];

?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<link rel="stylesheet" href="asset/css/jquery-ui.css">
<script src="asset/js/jquery-ui.js"></script>
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
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['username']);
    if (!empty($_POST['password'])){
        $_POST['un_password'] = $_POST['password'];
        $_POST['password'] = encryptpassword($_POST['password']);
    }
    else unset($_POST['password']);
    if ($tact == "user_insert") {
        $userObject = (object) $userCl->findOne(array("username"=>$_POST['username']));
        if (!$userObject->_id) {
            if (!empty($_POST['phone']))
                $userObject = (object) $userCl->findOne(array("phone"=>$_POST['phone']));
            if (!$userObject->_id) {
                $_POST['_id'] = strval(time());
                $_POST['datecreate'] = time();
                $_POST['view'] = 1;
                $_POST['like'] = 1;
                $_POST['status']=1;
//                $_POST['displayname']=$_POST['phone'];
                $result = $userCl->insert($_POST);
            } else {
                $status = "error";
                $errorMesssage = "Đã có người dùng với số điện thoại này";
            }
        } else {
            $status = "error";
            $errorMesssage = "Đã có người dùng với username này";
        }
    }
    else {
        $result = $userCl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
    }
    if (!isset($status)) {
        if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
        else header("Location: " . cpagerparm("status") . "status=success");
    }
}
##Get Data
if ($tact != "user_insert") $_POST = (array)$userCl->findOne(array("_id" => "$id"));
?>
<?php include("component/message.php"); ?>
<form class="form-horizontal" role="form" action="" method="post">
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin người dùng</a></li>
<!--    <li><a href="#category" role="tab" data-toggle="tab">Phân quyền</a></li>-->
</ul>

<div class="tab-content">
<div class="tab-pane active" id="info">
    <p>&nbsp;</p>
    <input type="hidden" name="acpt" value="1" />
    <!--<div class="form-group">
        <label class="col-sm-2 control-label">Chức vụ</label>

        <div class="col-sm-10">
            <select type="text" name="country" class="form-control">
            <?php /*foreach($countryList as $elem) { */?>
                <option value="<?php /*echo $elem['key'] */?>" <?php /*if ($elem['key']==$_POST['country']) echo 'selected="selected"' */?>> <?php /*echo $elem['name'] */?> </option>
            <?php /*} */?>
            </select>
        </div>
    </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label">Tên người dùng</label>

        <div class="col-sm-10">
            <input type="text" name="username" class="form-control" value="<?php echo $_POST['username'] ?>" placeholder="Tên người dùng">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Tên hiển thị</label>

        <div class="col-sm-10">
            <input type="text" name="displayname" class="form-control" value="<?php echo $_POST['displayname'] ?>" placeholder="Tên đầy đủ của người dùng">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Số điện thoại</label>

        <div class="col-sm-10">
            <input type="text" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?>" placeholder="Số điện thoại">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Password</label>

        <div class="col-sm-10">
            <input type="text" name="password" class="form-control" value="<?php echo $_POST['un_password']?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>

        <div class="col-sm-10">
            <input type="text" name="email" class="form-control" value="<?php echo $_POST['email'] ?>">
        </div>
    </div>


<!--    <div class="form-group">
        <label class="col-sm-2 control-label">Mở rộng</label>

        <div class="col-sm-10">
            <label>
                <input type="radio" class="col-sm-1" value="hot" name="isstatus" />&nbsp;Hot
            </label> |
            <label>
                <input type="radio" class="col-sm-1" value="new" name="isstatus" /> &nbsp;Mới
            </label> |
            <label>
                <input type="radio" class="col-sm-1" value="none" name="isstatus" /> &nbsp;Không gì cả
            </label>
        </div>
    </div>-->
    <div class="form-group">
        <input type="hidden" name="priavatar" id="avatar" value="<?php echo $_POST['priavatar'] ?>" />
        <label class="col-sm-2 control-label">Ảnh đại diện</label>

        <div class="col-sm-10">
            <input type="file" name="file_upload" id="file_upload" />

            <p>
                <img src="<?php echo $_POST['priavatar'] ?>" id="previewavatar" style="max-width: 350px;display:<?php echo strlen($_POST['priavatar']) > 0 ? "block" : "none"; ?>" />
            </p>

            <p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Profile</label>

        <div class="col-sm-10">
            <textarea rows="10" id="lyric" class="form-control" name="profile" placeholder="Profile của user"><?php echo $_POST['profile'] ?></textarea>
        </div>
    </div>
</div>
<div class="tab-pane" id="category">
    <label><input type="checkbox" id="checkallcat" class="con-sm-1" />&nbsp; Chọn tất cả</label>
    <?php
    $categorycl = $dbmg->category;
    $listselectedcat = $_POST['category'];
    #Đệ quy Category
    function dequy($parentid, $type) {
        global $categorycl, $listselectedcat;
        echo "<ul>";
        $cond['parentid'] = "$parentid";
        if (strlen($type) > 0) $cond['type'] = "$type";
        $listcat = iterator_to_array($categorycl->find(array("parentid" => "$parentid"), array("_id", "name","type"))->sort(array("_id" => -1)), false);
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

    dequy("0", "user");
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
        },100);
    });
</script>
<script>
    $(function () {
        $("#listimage").sortable();
        $("#listimage").disableSelection();
    });
</script>