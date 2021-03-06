<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$title = "Quản lý User";
$userCl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array();
$listmail = array();
$listId = array();
if(isset($q) && !empty($q)){
    $cond = array(
        '$or'=>array(
                array('namenonutf'=>new MongoRegex("/$q/iu")),
                array('_id'=>"$q"),
                array('phone'=> $q),
                array('email'=>$q),
                array('displayname'=>$q)
        )
    );
}
if(!empty($_GET['from'])){
//    $_GET['from'] = date('d/m/Y');
    $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
    $cond['datecreate']['$gte'] = strtotime($convertFrom);
}

if(!empty($_GET['to'])){
//    $_GET['to'] = date('d/m/Y');
    $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
    $cond['datecreate']['$lte'] = strtotime($convertTo);
}

if(!empty($_GET['chanel'])){
    switch ($_GET['chanel']){
        case 'fb':
            $cond['fbid'] = array('$ne'=>'','$exists'=>true);
            break;
        case 'gg':
            $cond['ggid'] = array('$ne'=>'','$exists'=>true);
            break;
        default:
            $cond['fbid'] = array('$exists' => false);
            $cond['ggid'] = array('$exists' => false);
            break;
    }
//    $cond['chanel'] = $_GET['chanel'];
}
if(!empty($_GET['status'])){
    switch ($_GET['status']){
        case '1':
            $cond['status'] = Constant::STATUS_DISABLE;
            break;
        case '2':
            $cond['pkg_expired'] = array('$exists'=>false);
            break;
        case '3':
            $cond['pkg_expired'] = array('$gte'=>time());
            break;
        case '4':
            $cond['pkg_expired'] = array('$lte'=>time());
            break;
        default:
            break;
    }
//    $cond['chanel'] = $_GET['chanel'];
}

if(!empty($_GET['regLession'])){
    $cond['reg_lession'] = $_GET['regLession'];
}
//print_r($cond);
$sort = array("datecreate" => -1);
$cursor = $userCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
foreach ($cursor as $aUser){
    $listmail[] = $aUser['email'];
    $listId[] = $aUser['_id'];
}
$listproduct = $userCl->find($cond)->sort($sort)->skip($cp)->limit($limit);
$cpage = $cp;
?>
    <script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#black" role="tab" data-toggle="tab">Danh sách</a></li>
        <li><a href="#email" role="tab" data-toggle="tab">Gửi email cho tập user này</a></li>
        <li><a href="#noti" role="tab" data-toggle="tab">Gửi thông báo cho tập user này</a></li>
        <li><a href="<?php echo cpagerparm("tact,id") ?>tact=user_chart">Biểu đồ</a></li>
    </ul>
<div class="tab-content">
    <div class="tab-pane active" id="black">
<div>
<?php if(acceptpermiss("user_insert")) { ?><a class="btn btn-sm btn-primary" href="<?php echo cpagerparm("tact,id,status") ?>tact=user_insert">Thêm mới</a><?php } ?>
</div>
<div style="margin-top: 10px">
    <form class="form-inline" role="form" action="" method="get">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","from","to","chanel","regLession"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <div class="form-group" style="margin-bottom: 5px">
            <input type="text" placeholder="Tên/số điện thoại/email" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
            <input type="text" placeholder="Từ ngày:" name="from" class="form-control datepicker" value="<?php echo $_GET['from'] ?>">
            <input type="text" placeholder="Đến ngày:" name="to" class="form-control datepicker" value="<?php echo $_GET['to'] ?>">
            <select name="status" class="form-control">
                <option value="">--Trạng thái--</option>
                <option value="1" <?php if($_GET['status']==1) echo 'selected' ?>>Chưa kích hoạt</option>
                <option value="2" <?php if($_GET['status']==2) echo 'selected' ?>>Chưa mua khóa học</option>
                <option value="3" <?php if($_GET['status']==3) echo 'selected' ?>>Khóa học hiệu lực</option>
                <option value="4" <?php if($_GET['status']==4) echo 'selected' ?>>Khóa học hết hạn</option>
            </select>
            <select name="chanel" class="form-control">
                <option value="">--Kênh--</option>
                <option value="fb" <?php if($_GET['chanel']=='fb') echo 'selected' ?>>Facebook</option>
                <option value="gg" <?php if($_GET['chanel']=='gg') echo 'selected' ?>>Google</option>
                <option value="tt" <?php if($_GET['chanel']=='tt') echo 'selected' ?>>Trực tiếp</option>
            </select>
            <select name="regLession" class="form-control">
                <option value="">--Đăng ký bài học--</option>
                <?php foreach (Common::getAllLessionType() as $k=>$lessionType): ?>
                <option value="<?php echo $k ?>" <?php if($_GET['regLession']==$k) echo 'selected' ?>><?php echo $lessionType ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" class="btn btn-success" value="Tìm">
        </div>
    </div>
</form>
</div>

<form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
<!--        <th>Ảnh</th>-->
        <th>Email</th>
        <th>Ngày tạo</th>
        <th>Thời hạn khóa học</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($listproduct as $item) { ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
<!--            <td class="col-md-2"><img src="--><?php //echo $item['priavatar'] ?><!--" class="img-thumbnail" style="max-width: 120px;" /></td>-->
            <td><?php echo $item['email'] ?>
                <p class="text-muted"><?php echo $item['_id'] ?></p>
            </td>
            <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
            <td><?php echo isset($item['pkg_expired']) ? ($item['pkg_expired'] > time() ? date("d-m-Y", $item['pkg_expired']) : 'Hết hạn') : 'Chưa đăng ký' ?></td>
            <td>
                <?php if(acceptpermiss("user_sendmail")) { ?><a href="<?php echo cpagerparm("act,tact,status,id") ?>act=email&tact=email_new&email=<?php echo $item['email'] ?>">Gửi email</a> |<?php } ?>
                <?php if(acceptpermiss("user_sendnotify")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_sendnotify&id=<?php echo $item['_id'] ?>">Gửi thông báo</a> |<?php } ?>
                <?php if(acceptpermiss("user_rolegroup_insert")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_rolegroup_insert&id=<?php echo $item['_id'] ?>">Nhóm quyền</a> |<?php } ?>
                <?php if(acceptpermiss("user_rolegroup_permission")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_rolegroup_permission&id=<?php echo $item['_id'] ?>">Quyền riêng</a> |<?php } ?>
                <?php if(acceptpermiss("user_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=user_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php } ?>
                <?php if(acceptpermiss("user_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=user_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
</div>
    <div class="tab-pane" id="email">
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
                    <textarea rows="10" id="content" name="content" class="form-control" placeholder="Nhập nội dung bài viết"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="sendMail()" id="submitBtn">Bắt đầu gửi</button>
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane" id="noti">
        <form class="form-horizontal" role="form" action="" method="post" style="margin-top: 25px">
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung thông báo</label>
                <div class="col-sm-10">
                    <textarea rows="10" id="noticontent" class="form-control" name="mss" placeholder="Nội dung thông báo"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="sendNoti()" id="submitBtn">Gửi thông báo</button>
                </div>
            </div>
        </form>
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
                relative_urls : false,
                remove_script_host : false,
                convert_urls : true,
                content_css: "plugin/tinymce/tinymce.css",
                external_image_list_url : "plugin/tinymce/myexternallist.js"
            });
        });

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

        function sendNoti() {
            id = '<?php echo implode(',',$listId)  ?>';
            content = $('#noticontent').val();

//        console.log(email); return false;
            $.post('incoming.php?act=sendNoti', {
                id:id, content: content
            }, function (re) {
                alert(re.mss)
            });
//        $('#submitBtn').hide();
//        $('#percentBar').show();
//        $('#percent').show();
//        send();
        }
    </script>
<?php include("component/paging.php") ?>