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
$title = "Gửi email cho user";
//$emailCl = $dbmg->email_log;
//print_r($_GET['lession']);
$userCl = $dbmg->user;
$cond = array();
$listmail = array();
//$cond['reg_lession'] = array('$ne'=>'','$exists'=>true);
$cond['email'] = array('$nin'=>array(null,''),'$exists'=>true);
$startdate = $_GET['start'];
$enddate = $_GET['end'];
if(isset($startdate) && !empty($startdate)){
    $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
    $cond['datecreate']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
}
if(isset($enddate) && !empty($enddate)){
    $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
    $cond['datecreate']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
}
//if(isset($_GET['lession']) && !empty($_GET['lession'])){
//    $cond['reg_lession'] = $_GET['lession'];
//}
if(isset($_GET['email']) && !empty($_GET['email'])){
    $cond['email'] = $_GET['email'];
}
//print_r($_GET['lession']);
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $userCl->find($cond)->sort($sort);
//$allRecord = $cursor;

//print_r(implode(',',$listmail));
$rowcount = $cursor->count();
foreach ($cursor as $aUser){
    $listmail[] = $aUser['email'];
}
//print_r($listmail);
$list = $userCl->find($cond)->sort($sort)->skip($cp)->limit($limit);

#Post Process
if (isset($_POST['acpt'])) {
    $title = $_POST['title'];
    echo $title;
}
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
<!--    <li><a href="--><?php //echo cpagerparm("tact,id") ?><!--">Lịch sử Email</a></li>-->
    <li class="active"><a href="#list" role="tab" data-toggle="tab">Danh sách user</a></li>
    <li><a href="#send" role="tab" data-toggle="tab">Gửi email cho tập user này</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="list">
        <p>&nbsp;</p>
        <form class="form-inline" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("lession","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $_GET['email'] ?>">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $_GET['start'] ?>">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $_GET['end'] ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Tìm kiếm">
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) {
//                    $user = $userCl->findOne(array('_id'=>strval($item['userid'])));
//                    $lessionName = '';
////                    print_r($item);
//                    if(isset($item['itemid']) && !empty($item['itemid'])){
//                        $cl = Common::getClFromType($item['action']);
//                        $cl = $dbmg->$cl;
//                        $lession = $cl->findOne(array('_id'=>$item['itemid']));
//                        $lessionName = $lession['name'];
//                    }
                    ?>
                    <tr>
                        <td><?php echo isset($item['email']) ? $item['email'] : '' ?></td>
                        <td><?php echo date('d/m/Y H:i', $item['datecreate']) ?></td>
                        <td><a href="<?php echo cpagerparm("tact,id,lession") ?>tact=email_new&email=<?php echo isset($item['email']) ? $item['email'] : '' ?>">Gửi mail</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
    <div class="tab-pane" id="send">
        <form class="form-horizontal" role="form" action="" method="post" style="margin-top: 25px">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-10">
                    <input type="text" id="txtTitle" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
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
                    <button type="button" class="btn btn-default" onclick="sendMail()" id="submitBtn">Bắt đầu gửi</button>
                </div>
            </div>
        </form>
<!--        <div style="clear: both"></div>-->
<!--        <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">-->
<!--            <div id="process" style="background: green; height: 10px; width: 0;"></div>-->
<!--        </div>-->
<!--        <div class="text-center">-->
<!--            <span id="percent"></span>-->
<!--        </div>-->
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
//
//    max = $('#allUid span').size();
//    index = 0;
//    console.log(max);
    function sendMail() {
        email = '<?php echo implode(',',$listmail)  ?>';
        title = $('#txtTitle').val();
        content = $('#content').val();

//        console.log(email); return false;
        $.post('incoming.php?act=sendMail', {
            email:email, title: title, content: content
        }, function (re) {
            alert(re.mss)
        });
//        $('#submitBtn').hide();
//        $('#percentBar').show();
//        $('#percent').show();
//        send();
    }
    
//    function send() {
//        if(index >= max){
//            $('#submitBtn').show();
//            index = 0;
//            return false;
//        }
//        email = $('#allUid span').eq(index).html();
//        title = $('#txtTitle').val();
//        content = $('#content').val();
//        action = $('#chkLession').val();
//        console.log(email+'-'+title+'-'+content);
//        $.post('incoming.php?act=sendmail', {
//            email: email, content: content, title: title, action: action
//        }, function (re) {
//            console.log(re);
//            if(re.success){
//
//            }else{
//
//            }
//            var percent = (parseInt(index)+1)*100/max;
//            showPercent(Math.ceil(percent));
//            index++;
//            setTimeout(function(){
//                send();
//            },100);
//        }, 'json')
//    }
//
//    function showPercent(number){
//        $('#process').css('width', number+'%');
//        $('#percent').html(number+'%');
//    }
</script>






