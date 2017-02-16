<?php
$title = "Bài tập trắc nghiệm luyện ngữ âm";
$newscl = $dbmg->luyennguam_baitap;
$id = $_GET['id'];
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>tact=lna_tn_view">Trở về danh sách bài tập</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    if ($tact == "lna_tn_insert") {
        $_POST['_id'] = (string)strtotime("now");
        $_POST['datecreate'] = (string)strtotime("now");
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
if ($tact != "lna_tn_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin bài tập</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <input type="hidden" name="lnaid" value="<?php echo $_GET['lnaid'] ?>" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Câu hỏi</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?>">
                </div>
            </div>
            <input type="hidden" name="type" value="lna_tracnghiem">
            <div class="form-group">
                <label class="col-sm-2 control-label">Mô tả ngắn / Gợi ý</label>

                <div class="col-sm-10">
                    <input type="text" name="captions" class="form-control" value="<?php echo $_POST['captions'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Thứ tự</label>

                <div class="col-sm-10">
                    <input type="text" name="sort" class="form-control" value="<?php echo $_POST['sort'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Trạng thái</label>
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
                <label class="col-sm-2 control-label">Đáp án đúng</label>

                <div class="col-sm-10">
                    <input type="text" name="trueaw" class="form-control" value="<?php echo $_POST['trueaw'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10"><a href="javascript:void(0)" onclick="addAnswer()">Thêm câu trả lời</a></div>
            </div>
            <div class="listaw">
                <?php
                foreach($_POST['aw'] as $key=>$item){
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label txtaw">Câu trả lời <?php echo $key+1 ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="aw[]" class="form-control" value="<?php echo $item ?>">
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
            hoặc <a href="<?php echo cpagerparm("tact,id") ?>tact=lna_tn_view">Thoát</a> |
            <label><input type="checkbox" checked="checked" value="1" name="redirect" />&nbsp; Không chuyển hướng sau
                khi nhập xong</label>
        </div>
    </div>
</form>
<div class="template" style="display: none">
    <div class="form-group">
        <label class="col-sm-2 control-label txtaw">Câu trả lời</label>
        <div class="col-sm-5">
            <input type="text" name="aw[]" class="form-control">
        </div>
        <div class="col-sm-1">
            <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Xóa</a>
        </div>
    </div>
</div>
<script>
    function addAnswer(){
        $('.listaw').append($('.template').html());
        reindexlabel();
    }
    function reindexlabel(){
        var a = $('.listaw .txtaw');
        $.each(a,function(i,v){
            $(this).text("Câu trả lời "+(i+1));
        })
    }
</script>