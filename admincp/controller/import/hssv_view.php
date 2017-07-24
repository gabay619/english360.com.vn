<?php
$title = "Quản lý User Sự kiện Đồng hành cùng HSSV";
$userCl = $dbmg->user;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
if(isset($q)){
    $cond = array(
        '$or'=>array(
            array('namenonutf'=>new MongoRegex("/$q/iu")),
            array('_id'=>"$q"),
            array('phone'=> $q)
        )
    );
}
else $cond = array();
$cond['event'] = Event::HOC_SINH_SINH_VIEN;
$sort = array("datecreate" => -1);
$cursor = $userCl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listproduct = $cursor->skip($cp)->limit($limit);
$cpage = $cp;
parse_str($_SERVER['QUERY_STRING'], $param);
unset($param['act']);
$exportUrl = 'incoming.php?act=exportHssv&'.http_build_query($param);
?>
<!--<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=--><?php //echo strtotime("now") ?><!--"></script>-->
<!--<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />-->
<script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="text-right row">
        <div class="col-xs-2 text-left">
            <?php if(acceptpermiss("import_hssv_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=hssv_insert" class="btn btn-sm btn-primary">Thêm mới</a><?php } ?>
        </div>
        <?php if(acceptpermiss("import_hssv")) { ?>
        <div class="col-xs-2 text-left">
            <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Chọn file...</span>
        <!-- The file input field used as target for the file upload widget -->
                <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadMedia" />
            </span>
<!--            <input type="file" name="file_upload" id="file_upload" />-->
        </div>
        <div class="col-xs-1">
            <button onclick="importHssv()" class="btn btn-sm btn-success">Import Excel</button>
        </div>
        <div class="col-xs-2">
            <a href="<?php echo cpagerparm("tact,id,status") ?>tact=hssv_mt" class="btn btn-sm btn-info">Bắt đầu đăng ký</a>
        </div>
        <div class="col-xs-2">
            <a href="<?php echo $exportUrl ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-export"></i>Export ngoại mạng</a>
        </div>
        <div class="col-xs-2">
            <a class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=hssv_delete&id=all">Xóa tất cả</a>
        </div>
        <?php } ?>
        <div class="col-xs-4 right">
            <form action="" method="get">
                <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                        <input type="text" placeholder="Tên hoặc số điện thoại" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
                    </div>
                </div>
            </form>
        </div>

    </div>
    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                <th>Phone</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Xem mật khẩu</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listproduct as $item) { ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="phone[]" value="<?php echo $item['phone'] ?>" /></td>
                    <td><?php echo $item['phone'] ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
                    <td><a href="javascript:getPassword('<?php echo $item['_id'] ?>')">Xem</a></td>
                    <td>
                        <?php if(acceptpermiss("import_hssv_insert")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=hssv_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php } ?>
                        <?php if(acceptpermiss("import_hssv_insert")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=hssv_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>
<script>
    function getPassword(id){
        $.post('incoming.php?act=getPassword', {
            id:id
        }, function(result){
            s=prompt('Mật khẩu của user:',result.password);
        },'json')
    }

    function importHssv() {
        $.post('incoming.php?act=importHssv', {

        }, function(result){
            if(result.success){
                location.reload();
            }else alert(result.mss)
        },'json')
    }

    $(function () {

        $('#file_upload').fileupload({
            dataType: 'json',
            maxFileSize: 2000000000,

            done: function (e, data) {
                obj = data.result;
                console.log(obj)
                if (obj.status == 200) {
                    $(this).parent().parent().find('.progress').remove();
                    $('#avatar').val(obj.file.path);
                    $('#previewavatar').attr('src', obj.file.path);
                    $('#previewavatar').fadeIn();
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

//        setTimeout(function() {
//            $('#file_upload').uploadify({
//                'swf': 'plugin/uploadify/uploadify.swf',
//                'uploader': 'incoming.php?act=uploadHssv',
//                'onUploadSuccess': function (file, data, response) {
//                    var obj = JSON.parse(data);
//                    if (obj.status == 200) {
//                        $('#avatar').val(obj.file.path);
//                        $('#previewavatar').attr('src', obj.file.path);
//                        $('#previewavatar').fadeIn();
//
//                    } else {
//                        alert(obj.mss);
//                    }
//                }
//            });
//        },100)
    })
</script>
