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
$title = "Gửi SMS";
//$emailCl = $dbmg->email_log;
//print_r($_GET['lession']);
$userCl = $dbmg->user;
$cond = array();
$cond['reg_lession'] = array('$ne'=>'','$exists'=>true);
$cond['email'] = array('$ne'=>'','$exists'=>true);
if(isset($_GET['lession']) && !empty($_GET['lession'])){
    $cond['reg_lession'] = array('$all'=>$_GET['lession']);
}

$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $userCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);

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
    <li class="active"><a href="#list" role="tab" data-toggle="tab">Upload danh sách SĐT</a></li>
    <li><a href="#send" role="tab" data-toggle="tab">Gửi sms cho tập user này</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="list">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-5" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("lession","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="file" name="file_upload" id="file_upload" />
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover" id="tablePhone">
                <thead>
                <tr>
                    <!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>STT</th>
                    <th>Phone</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>
    </div>
    <div class="tab-pane" id="send">
        <form class="form-horizontal" role="form" action="" method="post" style="margin-top: 25px">
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung SMS</label>
                <div class="col-sm-10">
                    <textarea rows="10" id="content" name="content" class="form-control" placeholder="Nhập nội dung bài viết"><?php echo $_POST['content'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="sendSMS()" id="submitBtn">Bắt đầu gửi</button>
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
        setTimeout(function() {
            $('#file_upload').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'incoming.php?act=uploadExcel',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        var list = obj.data;
                        $.each(list, function(index, value) {
                            htmlx = '<tr>' +
                                    '<td>'+index+'</td>'+
                                    '<td>' + value["A"] + '</td>'+
                                    '<td></td>'
                                    '</tr>'
                            $('#tablePhone tbody').append(htmlx);
                        });
//                        console.log(list.length);
//                        for(i=1;i<=list.length;i++){
//                            htmlx = '<tr>' +
//                                '<td>' + list[i]["A"] + '</td>'
//                                '</tr>'
//                            $('#tablePhone tbody').append(htmlx);
//                        }
//
//                        $('#avatar').val(obj.file.path);
//                        $('#previewavatar').attr('src', obj.file.path);
//                        $('#previewavatar').fadeIn();
                    } else {
                        alert(obj.mss);
                    }
                }
            });
        },100)

//        $('#content').tinymce({
//            script_url: 'plugin/tinymce/tiny_mce.js',
//            elements: "ajaxfilemanager",
//            theme: "advanced",
//            skin: "default",
//            width: "100%",
//            height: 400,
//            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,legacyoutput",
//            image_advtab: true,
//            file_browser_callback: "ajaxfilemanager",
//            theme_advanced_buttons1: "video,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,fontselect,fontsizeselect",
//            theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
//            theme_advanced_buttons3: "tablecontrols",
//            theme_advanced_toolbar_location: "top",
//            theme_advanced_toolbar_align: "left",
//            theme_advanced_statusbar_location: "bottom",
//            theme_advanced_resizing: true,
//            apply_source_formatting: true,
//            content_css: "plugin/tinymce/tinymce.css",
//            external_image_list_url : "plugin/tinymce/myexternallist.js"
//        });
    });

    max = 0;
    index = 0;
    console.log(max);
    function sendSMS() {
//        email = [<?php //foreach ($cursor as $k=>$item) echo "'".$item['email']."'," ?>//];
//        title = $('#txtTitle').val();
//        content = $('#content').val();
//
////        console.log(email); return false;
//        $.post('incoming.php?act=sendMail', {
//            email:email, title: title, content: content
//        }, function (re) {
//            alert('Thanh cong')
//        })
        max = $('#tablePhone tbody tr').size();
        $('#submitBtn').hide();
        $('#percentBar').show();
        $('#percent').show();
        send();
    }

    function send() {
        if(index >= max){
            $('#submitBtn').show();
            index = 0;
            return false;
        }
        phone = $('#tablePhone tbody tr:eq('+index+') td:eq(1)').html();
        content = $('#content').val();
        console.log(phone+'-'+content);
        $.post('incoming.php?act=sendSMS', {
            phone: phone, content: content
        }, function (re) {
            console.log(re);
            if(re.success){
                $('#tablePhone tbody tr:eq('+index+') td:eq(3)').html('<b class="text-success">Success</b>');
            }else{
                $('#tablePhone tbody tr:eq('+index+') td:eq(3)').html('<b class="text-danger">Failed</b>');
            }
            var percent = (parseInt(index)+1)*100/max;
            showPercent(Math.ceil(percent));
            index++;
            setTimeout(function(){
                send();
            },100);
        }, 'json')
    }

    function showPercent(number){
        $('#process').css('width', number+'%');
        $('#percent').html(number+'%');
    }
</script>






