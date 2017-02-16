<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/10/2016
 * Time: 10:52 AM
 */
//error_reporting(E_ALL);
//ini_set('display_errors',1);
//echo 1;die;
$title = "Quản lý User đăng ký bài học";
//$emailCl = $dbmg->email_log;
//print_r($_GET['lession']);
$userCl = $dbmg->user;
$emailCl = $dbmg->email_log;
$emailQueue = $dbmg->email_queue;

if (isset($_POST['acpt'])) {
    $email = $_GET['email'];
    $title = $_POST['title'];
//    $lession = $_POST['lession'];
    $content = $_POST['content'];
    $emailQueue->insert(array(
        'to' => $email,
        'subject' => $title,
        'content' => $content,
    ));
    $_SESSION['status'] = 'success';
//    $user = $userCl->findOne(array('email'=>$email));
//    $mail = new \helpers\Mail($email,$title,$content);
//    if($mail->send()){
//        $emailCl->insert(array(
//            '_id' => strval(time()),
//            'to' => $email,
//            'userid' => $user['_id'],
//            'action' => $lession,
//            'itemid' => '',
//            'datecreate' => time()
//        ));
//        $_SESSION['status'] = 'success';
//    }
//    else $_SESSION['status'] = 'error';
}

?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("email,id,tact") ?>tact=email_user">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li><a href="#send" role="tab" data-toggle="tab">Gửi email</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="send">
        <form class="form-horizontal" role="form" action="" method="post" style="margin-top: 25px">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" id="txtTitle" name="title" class="form-control" value="<?php echo $_POST['title'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung Email</label>
                <div class="col-sm-10">
                    <textarea rows="10" id="content" name="content" class="form-control" placeholder="Nhập nội dung bài viết"><?php echo $_POST['content'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="acpt">Gửi</button>
                </div>
            </div>
        </form>
        <div style="clear: both"></div>
        <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">
            <div id="process" style="background: green; height: 10px; width: 0;"></div>
        </div>
        <div class="text-center">
            <span id="percent"></span>
        </div>
    </div>
</div>
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
</script>






