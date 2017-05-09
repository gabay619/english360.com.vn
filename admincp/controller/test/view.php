<?php
$title = "Quản lý bài kiểm tra trình độ";
//$categorycl = $dbmg->category;
//$newscl = $dbmg->nguphap;
$usercl = $dbmg->user;
$testcl = $dbmg->test;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array();
if(!empty($q)){
    $cond = array(
        '$or'=>array(
            array('namenonutf'=>new MongoRegex("/$q/iu")),
            array('content'=>new MongoRegex("/$q/iu")),
            array('_id'=>"$q"),
        )
    );
}
if(!empty($_GET['level'])){
    $cond['level'] = intval($_GET['level']);
}
if(!empty($_GET['type'])){
    $cond['type'] = $_GET['type'];
}

//print_r($cond);
$sort = array("datecreate" => -1);
$cursor = $testcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor->skip($cp)->limit($limit);
$typeArr = array(
    'test_nguphap' => 'Ngữ pháp',
    'test_tuvung' => 'Từ vựng',
    'test_nghe' => 'Nghe hiểu',
    'test_doc' => 'Đọc hiểu'
);
?>
    <script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
    <script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
    <link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="row">
<div class="col-xs-3" style="margin-bottom: 15px">
<?php if(acceptpermiss("test_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=test_insert">Thêm mới</a><?php }?>
    -
    <a href="<?php echo cpagerparm("tact,id,status") ?>tact=test_level_view">Các mức trình độ</a>
</div>
<div class="col-xs-12">
<form action="" method="get" class="form-inline">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <input type="text" placeholder="Tiêu đề hoặc mã" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
        <input type="text" placeholder="Người đăng" name="uname" value="<?php echo $_GET['uname'] ?>" class="form-control">
        <input type="text" placeholder="Level" name="level" value="<?php echo $_GET['level'] ?>" class="form-control">
        <select name="type" class="form-control">
            <option value="">--Chọn một--</option>
            <?php foreach ($typeArr as $key=>$val): ?>
                <option value="<?php echo $key ?>" <?php if($_GET['type']==$key) echo 'selected' ?>><?php echo $val ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" class="btn btn-primary" value="Tìm">
    </div>
    <div class="form-group">
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Import</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="Filedata" data-url="incoming.php?act=uploadTest" />
        </span>
    </div>
</form>

</div>
</div>

<form action="<?php echo cpagerparm("tact,id,status") ?>tact=test_delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
        <th>Tiêu đề</th>
        <th>Loại</th>
        <th>Level</th>
        <th style="width: 100px">Người tạo</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>    
    <?php foreach ($listnews as $item) {
        $user = $usercl->findOne(array('_id'=>$item['usercreate'] ),array('username'));
        ?>
        <tr>
            <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $typeArr[$item['type']] ?></td>
            <td><?php echo $item['level'] ?></td>
            <td><?php echo $user['username'] ?></td>
            <td>
                <?php if(acceptpermiss("test_update")) { ?><a class="btn btn-sm btn-primary" href="<?php echo cpagerparm("tact,status,id") ?>tact=test_update&id=<?php echo $item['_id'] ?>">Sửa</a><?php }?>
                <?php if(acceptpermiss("test_delete")) { ?><a class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=test_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                <a class="btn btn-sm btn-info" href="/test/view?id=<?php echo $item['_id'] ?>" target="_blank">Test</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
    <script>
        $(document).ready(function() {
            $('#fileupload').fileupload({
                dataType: 'json',
                done: function (e, data) {
//                    console.log(data.result);return false;
                    obj = data.result;
                    if (obj.status == 200) {
                        location.reload();
//                        max = obj.rs.length;
//                        for (i = 0; i <= obj.rs.length; i++) {
//                            stt = parseInt(i) + 1;
//                            htmlx = '<tr>' +
//                                '<td>' + stt + '</td>' +
//                                '<td class="ten-casi">' + obj.rs[i]['ca_si'] + '</td>' +
//                                '</tr>';
//                            $('#tableSong tbody').append(htmlx);
//                        }
                    } else {
                        alert(obj.mss);
                    }
//                $.each(data.result.files, function (index, file) {
//                    $('<p/>').text(file.name).appendTo(document.body);
//                });
                }
            });
        })
    </script>
<?php include("component/paging.php") ?>