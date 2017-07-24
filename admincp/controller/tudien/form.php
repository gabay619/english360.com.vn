<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$title = "Thông tin từ";
$newscl = $dbmg->tudien;
$id = $_GET['id'];
?>
<!--<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />-->
<script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/message.php"); ?>
<?php
#Post Process
if (isset($_POST['acpt'])) {
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
    if ($tact == "tudien_insert") {
        $_POST['_id'] = (string)strtotime("now");
        foreach($_POST['charator'] as $key=>$item){
            $lp['_id'] = (string)strtotime("now").rand(0,999);
            $lp['catid'] = $_POST['catid'];
            $lp['key'] = strtoupper(trim(substr($item,0,1)));
            $lp['value'] = $item;
//            $lp['linkdict'] = importexcel($_POST['linkdict']);
            $lp['datecreate'] = strtotime("now");
            $lp['content'] = $_POST[$key]['content'];
            $result = $newscl->insert($lp);
        }
        if (strlen($_POST['linkdict'])) {
            include "../plugin/Classes/PHPExcel.php";
            $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].$_POST['linkdict']);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            array_shift($sheetData);
            foreach($sheetData as $elem) {
                unset($lp);
//                echo $elem('B');
                $lp['_id'] = (string)strtotime("now").mt_rand(1000000 ,9000000);
                $lp['catid'] = strval($elem['A']);
                $lp['key'] = convert_vi_to_en(substr($elem['B'],0,1));
                /*$lp['value'] = $elem['C'];*/
                $lp['value'] = $elem['B'];
                $lp['content'] = $elem['C'];
                $lp['datecreate'] = strtotime("now");
                /*$lp['content'] = $_POST[$key]['content'];*/
//                var_dump($lp);die;
                $result = $newscl->insert($lp);
            }
        }

    }
    else {
        foreach($_POST['charator'] as $key=>$item){
            $lp['key'] = strtoupper(trim(substr($item,0,1)));
            $lp['value'] = $item;
            $lp['content'] = $_POST[$key]['content'];
            $lp['linkdict'] = $_POST['linkdict'];
            $result = $newscl->update(array("_id" => "$id"), array('$set' => $lp), array("upsert" => false));
        }

    }

    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
    else header("Location: " . cpagerparm("status") . "status=success");
    exit();
}
##Get Data
if ($tact != "tudien_insert") $_POST = (array)$newscl->findOne(array("_id" => "$id"));
else {
    $_POST['catid'] = $_GET['catid'];
}
?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin từ</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <div class="form-group">
                <label class="col-sm-2 control-label">Chuyên mục</label>
                <input type="hidden" name="catid" value="<?php echo $_POST['catid'] ?>">
                <div class="col-sm-10">
                    <?php
                    $categorycl = $dbmg->category;
                    $catid = $_POST['catid'];
                    $c = (array)$categorycl->findOne(array("_id"=>$catid),array("_id","name"));
                    echo $c['name'];
                    ?>
                </div>
            </div>
            <input type="hidden" name="acpt" value="1" />
            <input type="hidden" name="catid" value="<?php echo $_POST['catid'] ?>" />
            <?php if ($tact == "tudien_insert") { ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10"><a href="javascript:void(0)" onclick="addAnswer()">Thêm từ</a></div>
            </div>
            <?php } ?>
            <div class="listform">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nội dung</label>
                    <div class="col-sm-5">
                        Từ ngữ
                        <input type="text" name="charator[]" class="form-control" placeholder="Từ ngữ" value="<?php echo $_POST['value'] ?>">
                    </div>
                    <div class="col-sm-5">
                        Nghĩa:
                        <!--<input type="text"  name="content" class="form-control" value="<?php /*echo $_POST['content'] */?>" placeholder="Nghĩa của từ">-->
                        <input type="text" name="content[]" class="form-control" placeholder="Nghĩa của từ" value="<?php echo $_POST['content'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Link Từ điển</label>
                    <div class="col-sm-10">
                        <input onclick="" type="text" name="linkdict" id="linkdict" class="form-control" value="<?php echo $_POST['linkdict'] ?>" placeholder="Nhập link Từ điển">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Chọn file...</span>
                            <!-- The file input field used as target for the file upload widget -->
                        <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
                    </span>
<!--                        <input type="file" name="file_upload" id="file_upload" />-->
                    </div>
                </div>
            </div>
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
<div style="display: none" class="template">
    <div class="form-group">
        <label class="col-sm-2 control-label">Từ ngữ</label>
        <div class="col-sm-5">
            Từ ngữ
            <input type="text" name="charator[]" class="form-control" placeholder="Từ ngữ">
        </div>
        <div class="col-sm-5">
            Nghĩa:
            <input type="text" name="content[]" class="form-control" placeholder="Nghĩa của từ">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Link Từ điển</label>
        <div class="col-sm-10">
           <input  type="text" name="linkdict" id="linkdict" class="form-control" value="<?php echo $_POST['linkdict'] ?>" placeholder="Nhập link Từ điển">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Chọn file...</span>
            <!-- The file input field used as target for the file upload widget -->
                    <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
                </span>
<!--            <input type="file" name="file_upload" id="file_upload" />-->
        </div>
    </div>
</div>
<script>
    function addAnswer(){
        $('.listform').append($('.template').html());
    }

    $('#file_upload').fileupload({
        dataType: 'json',
        maxFileSize: 2000000000,

        done: function (e, data) {
            obj = data.result;
            console.log(obj)
            if (obj.status == 200) {
                $(this).parent().parent().find('.progress').remove();
                $('#linkdict').val(obj.file.path);
            } else {
                alert(obj.mss);
            }
        }
    }).on('fileuploadadd', function (e, data) {
        html = '<div class="progress">'+
            '<div class="progress-bar progress-bar-success"></div>'+
            '</div>';
        $(this).parent().parent().append(html);
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        console.log(progress);
        $(this).parent().parent().find('.progress .progress-bar').css(
            'width',
            progress + '%'
        );
    });

//    setTimeout(function(){
//    $('#file_upload').uploadify({
//        'swf': 'plugin/uploadify/uploadify.swf',
//        'uploader': 'plugin/uploadify/uploadify.php',
//      /*  'fileTypeExts': '*.xlsx,*.xls',*/
//        'onUploadSuccess': function (file, data, response) {
//            var obj = JSON.parse(data);
//            if (obj.status == 200) {
//                $('#linkdict').val(obj.file.path);
//            } else {
//                alert(obj.mss);
//            }
//        }
//    },100);
    });
</script>