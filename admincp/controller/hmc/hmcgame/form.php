<?php
$title = "Thông tin nội dung";
$newscl = $dbmg->hmcgame;
$categorycl = $dbmg->category;
$gameParentCate = $categorycl->findOne(array('type'=>Constant::TYPE_HOCMACHOI, 'parentid'=>'0'));
$id = $_GET['id'];
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?ver=<?php strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>&tact=hmcgame_view">Thoát</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    if (count($_POST['category']) <= 0) $_POST['category'] = array();
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "hmcgame_insert") {
        $uinfo = $_SESSION['uinfo'];
        if (!isset($uinfo)) $uinfo["_id"] = "0";
        $_POST['usercreate'] = $uinfo["_id"];
        $_POST['_id'] = strval(time());
        $_POST['datecreate'] = time();
//        $listquestion = $_POST['question'];
//        foreach ($listquestion as $key => $val) {
//            $inform = array("avatar" => $val, "aw" => $_POST['aw'][$key], "category" => $_POST['category'], "_id" => "" . strtotime("now") . rand(0000, 9999), "usercreate" => $uinfo["_id"], "datecreate" => (string)strtotime("now"), "status" => "1");
//            $newscl->insert($inform);
//        }
        $newscl->insert($_POST);
    }
    else {
        $_POST['status'] = "1";
        $result = $newscl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
    }
    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
    exit();
}
##Get Data
if ($tact != "hmcgame_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
else{
    $_POST['category'][] = $gameParentCate['_id'];
    if(isset($_GET['catid']))
        $_POST['category'][] = $_GET['catid'];
}
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin</a></li>
        <li><a href="#category" role="tab" data-toggle="tab">Chuyên mục</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Mức độ</label>

                <div class="col-sm-10">
                    <select class="form-control" name="degree">
                        <?php foreach(Common::getAllGameDegree() as $key=>$val):?>
                        <option value="<?php echo $key ?>" <?php echo $_POST['degree']== $key?"selected":"" ?>><?php echo $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Level</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="level" value="<?php echo $_POST['level'] ?>">
                </div>
            </div>
            <div class="form-group">

            <?php for($i=0; $i<10; $i++):?>
                <label class="col-sm-2 control-label">Câu hỏi <?php echo $i+1?></label>
                <div class="col-sm-10" style="border: 1px solid #ccc">
                    <div class="form-group">
                        <input type="hidden" name="question[<?php echo $i ?>][avatar]" id="avatar_<?php echo $i?>" value="<?php echo $_POST['quesstion'][$i]['avatar'] ?>" />
                        <label class="col-sm-2 control-label">Chọn ảnh</label>

                        <div class="col-sm-10">
                            <input type="file" name="file_upload" id="file_upload_<?php echo $i?>" class="file-upload" data-id="<?php echo $i?>" />

                            <!--                    <p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Khuyến khích ảnh 555x260px)</p>-->
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div id="listquestion_<?php echo $i?>" class="col-md-10">
                            <?php //if ($tact == "hmcgame_update") { ?>
                                <div class="col-md-10">
                                    <div class="col-sm-2">
                                        <img class="thumbnailm col-md-10" src="<?php echo $_POST['question'][$i]['avatar'] ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="hidden" name="question[<?php echo $i?>][avatar]" value="<?php echo $_POST['question'][$i]['avatar'] ?>">
                                        <input type="text" class="form-control col-md-2" name="question[<?php echo $i?>][aw]" value="<?php echo $_POST['question'][$i]['aw'] ?>">
                                    </div>
                                </div>
                            <?php //} ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10"><a href="javascript:void(0)" onclick="addSelect(<?php echo $i?>)">Thêm câu trả lời</a></div>
                    </div>
                    <div class="listselect listselect-<?php echo $i?>">
                        <?php
                        foreach($_POST['question'][$i]['select'] as $key=>$item){
                            ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label txtselect">Câu trả lời <?php echo $key+1 ?></label>
                                <div class="col-sm-5">
                                    <input type="text" name="question[<?php echo $i?>][select][]" class="form-control" value="<?php echo $item ?>">
                                </div>
                                <div class="col-sm-1">
                                    <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php endfor; ?>
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
                //$listcat = iterator_to_array($categorycl->find(array("parentid" => "$parentid", "type" => "$type"), array("_id", "name"))->sort(array("_id" => -1)), false);
                $listcat = iterator_to_array($categorycl->find(array("parentid" => "$parentid", "type" => "$type"), array("_id", "name", "type"))->sort(array("_id" => -1)), false);
                foreach ($listcat as $cat) {
                    $id = $cat['_id'];
                    $attr = in_array($id, $listselectedcat) ? "checked" : "";
                    $cl = 'disabled';
                    if ($type == $cat['type']) $cl = '';
                    echo '<li><label><input ' . $cl . ' type="checkbox" ' . $attr . ' class="con-sm-1 catitem" name="category[]" value="' . $id . '" />&nbsp;' . $cat['name'] . "</label>";
                    $c = $categorycl->find(array("parentid" => "$id"))->count(); // Kiểm tra xem còn cat con không
                    if ($c > 0) dequy($id, $type); // Nếu còn - tiếp tục đệ quy đến khi hết
                    echo "</li>";
                }
                echo "</ul>";
            }

            dequy("0", Constant::TYPE_HOCMACHOI);

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
<div class="template" style="display: none">
    <div class="form-group">
        <label class="col-sm-2 control-label txtselect">Câu trả lời</label>
        <div class="col-sm-5">
            <input type="text" name="select[]" class="form-control">
        </div>
        <div class="col-sm-1">
            <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>
        </div>
    </div>
</div>
<script>
    $('#checkallcat').click(function () {
        if ($(this).is(':checked')) $('.catitem:not(:disabled)').prop('checked', true); else $('.catitem:not(:disabled)').prop('checked', false);
    });
    setTimeout(function () {
        <?php for($i=0; $i<10; $i++):?>
        $('#file_upload_<?php echo $i?>').uploadify({
            'swf': 'plugin/uploadify/uploadify.swf',
            'uploader': 'plugin/uploadify/uploadify.php',
            'onUploadSuccess': function (file, data, response) {
                var obj = JSON.parse(data);
                if (obj.status == 200) {
                    console.log($(this).attr('data-id'));
                    <?php if(!isset($id)) { ?>
                    var htmlx = '<div class="col-sm-10"><div class="col-sm-2"><input type="hidden" name="question[<?php echo $i?>][avatar]" value="' + obj.file.path + '">' + '<img class="thumbnailm col-md-10" src="' + obj.file.path + '">' + '</div>' + '<div class="col-sm-3">' + '<input name="question[<?php echo $i?>][aw]" type="text" value="" class="form-control col-md-2">' + '</div></div>';
                    $('#listquestion_<?php echo $i?>').html(htmlx);
                    <?php } else{ ?>
                    var htmlx = '<div class="col-sm-10"><div class="col-sm-2"><input type="hidden" name="question[<?php echo $i?>][avatar]" value="' + obj.file.path + '">' + '<img class="thumbnailm col-md-10" src="' + obj.file.path + '">' + '</div>' + '<div class="col-sm-3">' + '<input name="question[<?php echo $i?>][aw]" type="text" value="" class="form-control col-md-2">' + '</div></div>';
                    $('#listquestion_<?php echo $i?>').html(htmlx);
                    <?php } ?>
                } else {
                    alert(obj.mss);
                }
            }
        });
        <?php endfor; ?>
    }, 100);
</script>
<script>
    function addSelect(i){
        html = '<div class="form-group">'+
           '<label class="col-sm-2 control-label txtselect">Câu trả lời</label>'+
            '<div class="col-sm-5">'+
            '<input type="text" name="question['+i+'][select][]" class="form-control">'+
            '</div>'+
            '<div class="col-sm-1">'+
            '<a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>'+
            '</div>'+
            '</div>';
        $('.listselect-'+i).append(html);
        reindexlabel(i);
    }
    function reindexlabel(i){
        var a = $('.listselect-'+i+' .txtselect');
        $.each(a,function(i,v){
            $(this).text("Câu trả lời "+(i+1));
        })
    }
</script>