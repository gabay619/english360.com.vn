<?php
$title = "Quản lý Event";
$freecl = $dbmg->free_user;
$userCl = $dbmg->user;
$configCl = $dbmg->config;
$cond = array();
if(isset($_GET['phone'])){
    $searchPhone = $_GET['phone'];
    $cond['phone'] = $searchPhone;
}

$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("_id" => -1);
$cursor = $freecl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
//print_r(Network::sentMT('01262169297','TEST','test'));
//print_r(Network::sentMT('0903275310','TEST','test'));
//print_r(Network::sentMT('0936082061','TEST','test'));
//die;
//print_r($listbl);die;

?>
<!--<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=--><?php //echo strtotime("now") ?><!--"></script>-->
<!--<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />-->
<script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Danh sách số điện thoại</a></li>
    <li><a href="#excel" role="tab" data-toggle="tab">Import Excel</a></li>
    <!--    <li><a href="#config" role="tab" data-toggle="tab">Cấu hình</a></li>-->
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline col-sm-5" role="form" action="" method="post">
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" id="txtNewPhone">
                <button class="btn btn-primary" onclick="createNew()" type="button">Tạo mới</button>
                <button class="btn btn-danger" onclick="deleteAll();" type="button">Xóa hết</button>
            </div>
        </form>

        <form class="form-inline col-sm-5 pull-right" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $_GET['phone'] ?>">
                <input type="submit" class="btn btn-success" value="Tìm kiếm">
            </div>
        </form>
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=bl_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>Số điện thoại</th>
                    <th>Xem mật khẩu</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <!--                        <td><input type="checkbox" class="checkitem" name="phone[]" value="--><?php //echo $item['phone'] ?><!--" /></td>-->
                        <td><?php echo $item['phone'] ?></td>
                        <td><a href="javascript:getPassword('<?php echo $item['phone'] ?>')">Xem</a></td>
                        <td>
                            <a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=event1_delete&phone=<?php echo $item['phone'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
    <div class="tab-pane" id="excel">
        <form action="" class="form-horizontal" style="margin-top: 15px">
            <div class="col-xs-2">
                <span class="btn btn-success fileinput-button" style="margin-bottom: 5px">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Chọn file...</span>
                <!-- The file input field used as target for the file upload widget -->
                    <input id="file_upload" type="file" name="Filedata" data-url="incoming.php?act=uploadExcel" />
                </span>
<!--                <input type="file" name="file_upload" id="file_upload" />-->
            </div>

            <div style="clear: both"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung MT</label>
                <textarea name="" id="txtMtContent" cols="30" rows="10" class="col-sm-10" placeholder="Nội dung MT, dùng {pass} thay cho mật khẩu, {phone} thay cho số điện thoại"></textarea>
            </div>
            <div class="col-xs-1">
                <button onclick="sendSMS()" class="btn btn-sm btn-success" id="stBtn" type="button">Bắt đầu</button>
            </div>
            <!--            <h2 id="percent"></h2>-->
            <!--            <div id="listPhone" style="display: none"></div>-->
            <div style="clear: both"></div>
            <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">
                <div id="process" style="background: green; height: 10px; width: 0;"></div>
            </div>
            <div class="text-center">
                <span id="percent"></span>
            </div>
            <table class="table table-hover" id="tablePhone">
                <thead>
                <tr>
                    <!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>STT</th>
                    <th>Phone</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>
    </div>
    <!--    <div class="tab-pane" id="config">-->
    <!--        <form class="form-horizontal" role="form" action="" method="post">-->
    <!--            <div class="form-group">-->
    <!--                <label class="col-sm-2 control-label">Số ngày miễn phí</label>-->
    <!--                <div class="col-sm-10">-->
    <!--                    <input type="text" name="freeday" class="form-control">-->
    <!--                </div>-->
    <!--                <input name="submit" class="btn btn-default" value="OK"/>-->
    <!--            </div>-->
    <!--        </form>-->
    <!--    </div>-->
</div>

<script>
    var max = 0;
    $(function () {

        $('#file_upload').fileupload({
            dataType: 'json',
            maxFileSize: 2000000000,

            done: function (e, data) {
                obj = data.result;
                console.log(obj)
                if (obj.status == 200) {
                    $(this).parent().parent().find('.progress').remove();
                    var list = obj.data;
                    $.each(list, function(index, value) {
                        htmlx = '<tr>' +
                            '<td>'+index+'</td>'+
                            '<td>' + value["A"] + '</td>'+
                            '<td></td>'
                        '</tr>'
                        $('#tablePhone tbody').append(htmlx);
                    });
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
//                'uploader': 'incoming.php?act=uploadExcel',
//                'onUploadSuccess': function (file, data, response) {
//                    var obj = JSON.parse(data);
//                    if (obj.status == 200) {
////                        console.log(obj);return false;
//                        var list = obj.data;
//                        $.each(list, function(index, value) {
//                            htmlx = '<tr>' +
//                                '<td>'+index+'</td>'+
//                                '<td>' + value["A"] + '</td>'+
//                                '<td></td>'
//                            '</tr>'
//                            $('#tablePhone tbody').append(htmlx);
//                        });
////                        max = obj.phone.length;
////                        for(i=0;i<=obj.phone.length;i++){
////                            $('#listPhone').append('<span>'+obj.phone[i]+'</span>');
////                        }
//                    } else {
//                        alert(obj.mss);
//                    }
//                }
//            });
//        },100)
    })
    function sendSMS() {
        max = $('#tablePhone tbody tr').size();
        $('#submitBtn').hide();
        $('#percentBar').show();
        $('#percent').show();
        send();
    }


    var index = 0;
    function send() {
        if(index >= max){
            $('#submitBtn').show();
            index = 0;
            return false;
        }
        phone = $('#tablePhone tbody tr:eq('+index+') td:eq(1)').html();
        content = $('#txtMtContent').val();
//        console.log(phone+'-'+content);
        $.post('incoming.php?act=createFreeUser', {
            phone: phone, mtcontent: content
        }, function (re) {
            console.log(re);
            if(re.success){
                $('#tablePhone tbody tr:eq('+index+') td:eq(2)').html('<b class="text-success">Success</b>');
            }else{
                $('#tablePhone tbody tr:eq('+index+') td:eq(2)').html('<b class="text-danger">Failed</b>');
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

    function importFree() {
        if(index >= max) return false;
        phone = $('#listPhone span').eq(index).html();
        mtcontent = $('#txtMtContent').val();
        $.post('incoming.php?act=createFreeUser', {
            phone: phone, mtcontent:mtcontent
        }, function(result){
            index = parseInt(index)+1;
            percent = index/max * 100;
            $('#percent').html(percent +' %');
            setTimeout(function () {
                importFree();
            },1000)
        }, 'json');
    }

    function getPassword(phone){
        $.post('incoming.php?act=getPassword', {
            phone:phone
        }, function(result){
            s=prompt('Mật khẩu của user:',result.password);
        },'json')
    }

    function deleteAll() {
        if(confirm('Bạn muốn xóa tất cả user miễn phí?')){
            $.post('incoming.php?act=deleteAllFree', {}, function (re) {
                location.reload();
            });
            location.reload();
        }
    }

    function createNew(){
        phone = $('#txtNewPhone').val();
        mtcontent = $('#txtMtContent').val();
        $.post('incoming.php?act=createFreeUser', {
            phone: phone, mtcontent:mtcontent
        }, function(result){
            console.log(result);
            if(result.success){
//                s=prompt('User đã được tạo:',result.user);
//                location.reload();
            }else{
                alert(result.mss);
            }

        }, 'json');
    }
</script>






