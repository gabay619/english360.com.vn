<?php
$eucl = $dbmg->event_user;
$eventcl = $dbmg->event;
$usercl = $dbmg->user;
$eid = $_GET['eid'];
$event = $eventcl->findOne(array('_id'=>$eid));
$title = 'Quản lý User Event "'.$event['name'].'"';
//$uArr = array();
//$eventUser = iterator_to_array($eucl->find(array('eid'=>$eid)), false);
//foreach ($eventUser as $aUser){
//    $uArr[] = $aUser['uid'];
//}

$cond = array();
if(!empty($_GET['from'])){
    $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
    $cond['datecreate']['$gte'] = strtotime($convertFrom);
}
if(!empty($_GET['to'])){
    $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
    $cond['datecreate']['$lte'] = strtotime($convertTo);
}
if(!empty($_GET['phone'])){
    $user = $usercl->findOne(array('$or'=>array(
        array('phone'=>$_GET['phone']),
        array('email'=>$_GET['phone']),
        array('username'=>$_GET['phone'])
    )));
    if($user){
        $cond['uid'] = $user['_id'];
    }
}
$cond['eid'] = $eid;
//$cond = array(
//    '_id' => array('$in'=>$uArr)
//);
//if(isset($_GET['phone'])){
//    $cond['phone'] = $_GET['phone'];
//}
//if(isset($_GET['email'])){
//    $cond['email'] = $_GET['email'];
//}

$limit = 10;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$sort = array("datecreate" => -1);
$cursor = $eucl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
//print_r(Network::sentMT('01262169297','TEST','test'));
//print_r(Network::sentMT('0903275310','TEST','test'));
//print_r(Network::sentMT('0936082061','TEST','test'));
//die;
//print_r($listbl);die;
parse_str($_SERVER['QUERY_STRING'], $param);
unset($param['act']);
$exportUrl = 'incoming.php?act=exportEventUser&'.http_build_query($param);
?>
<script type="text/javascript" src="plugin/uploadify/jquery.uploadify.min.js?v=<?php echo strtotime("now") ?>"></script>
<link rel="stylesheet" type="text/css" href="plugin/uploadify/uploadify.css" />
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/flash_mss.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#black" role="tab" data-toggle="tab">Danh sách User</a></li>
    <!--    <li><a href="#config" role="tab" data-toggle="tab">Cấu hình</a></li>-->
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="black">
        <p>&nbsp;</p>
        <form class="form-inline" role="form" action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group" style="margin-bottom: 5px">
                <input type="text" placeholder="Số điện thoại" name="phone" class="form-control" value="<?php echo $_GET['phone'] ?>">
                <input type="text" placeholder="Từ ngày:" name="from" class="form-control datepicker" value="<?php echo $_GET['from'] ?>">
                <input type="text" placeholder="Đến ngày:" name="to" class="form-control datepicker" value="<?php echo $_GET['to'] ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Tìm">
            </div>
            <div class="" style="margin-top: 15px">
                <p class="help-block">Import file excel cột A là số điện thoại, cột B là email</p>
                <div class="col-xs-2 text-left">
                    <input type="file" name="file_upload" id="file_upload" />
                </div>
<!--                <div class="col-xs-2">-->
<!--                    <button onclick="importEvent()" class="btn btn-sm btn-success">Import Excel</button>-->
<!--                </div>-->
                <div class="col-xs-2">
                    <a class="btn btn-primary" href="<?php echo $exportUrl ?>"><i class="glyphicon glyphicon-export"></i> Export</a>
                </div>
                <div class="col-xs-2">
                    <button type="button" class="btn btn-success" onclick="newUser()">Thêm mới</button>
                </div>
            </div>
        </form>
        <!--        <form class="form-inline col-sm-5 pull-right" role="form" action="" method="get">-->
        <!--            --><?php //foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?><!-- <input type="hidden" name="--><?php //echo $key ?><!--" value="--><?php //echo $val ?><!--" /> --><?php //} ?>
        <!--            <div class="form-group">-->
        <!--                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="--><?php //echo $_GET['phone'] ?><!--">-->
        <!--                <input type="submit" class="btn btn-success" value="Tìm kiếm">-->
        <!--            </div>-->
        <!--        </form>-->
        <form action="<?php echo cpagerparm("tact,id,status") ?>tact=event_delete&tab=partner" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <!--                    <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
                    <th>ID</th>
                    <th>Phone</th>
                    <th>Username</th>
                    <th>Ngày đăng ký Event</th>
                    <th>Xem mật khẩu</th>
                    <th>ĐK gói cước</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) {
                    $user = $usercl->findOne(array('_id'=>$item['uid']));
                    ?>
                    <tr>
                        <!--                        <td><input type="checkbox" class="checkitem" name="phone[]" value="--><?php //echo $item['phone'] ?><!--" /></td>-->
                        <td><?php echo $user['_id'] ?></td>
                        <td><?php echo $user['phone'] ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo date('d/m/Y H:i', $item['datecreate']) ?></td>
                        <td><a href="javascript:getPassword('<?php echo $user['_id'] ?>')">Xem</a></td>
                        <td><?php echo empty($user['phone'])|| Network::getRealUserInfo($user['phone'])!=1 ? '<span class="text-danger">Không</span>' : '<span class="text-success">Có</span>' ?></td>
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=user_delete&id=<?php echo $item['_id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
        <?php include("component/paging.php") ?>
    </div>
    <div style="clear: both"></div>
    <div id="percentBar" style="border: 1px solid #000; margin: 0 auto; width: 500px; border-radius: 2px; display: none">
        <div id="process" style="background: green; height: 10px; width: 0;"></div>
    </div>
    <div class="text-center">
        <span id="percent"></span>
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
    var list = [];
    var max = 0;
    var index = 1;

    $(function () {
        setTimeout(function() {
            $('#file_upload').uploadify({
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'incoming.php?act=uploadExcel',
                'buttonText' : 'IMPORT EXCEL',
                'fileTypeExts' : '*.xlsx',
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    console.log(obj);
                    if (obj.status == 200) {
                        list = obj.data;
                        max = Object.keys(list).length;
                        $('#percentBar').show();
                        $('#percent').show();
                        regEvent();
//                        console.log(list.length);
//                        location.reload();
//                        $('#avatar').val(obj.file.path);
//                        $('#previewavatar').attr('src', obj.file.path);
//                        $('#previewavatar').fadeIn();

                    } else {
                        alert(obj.mss);
                    }
                }
            });
        },100)
    })
    
    function newUser() {
        var input = prompt("Nhập email hoặc số điện thoại");
        $.post('incoming.php?act=regEvent&eid=<?php echo $eid ?>', {
                phone: input, email: input
        }, function (re) {
            if(re.status == 200){
                alert('Thành công');
            }else 
                alert(re.mss);
        }, 'json');
    }

    function regEvent() {
        if(index > max){
//            $('#submitBtn').show();
//            index = 0;
//            location.reload();
            return false;
        }
        phone = list[index]["A"];
        email = list[index]["B"];
        $.post('incoming.php?act=regEvent&eid=<?php echo $eid ?>', {
            phone: phone, email: email, index:index
        }, function (re) {
            console.log(re);
//            if(re.success){
//                $('#tablePhone tbody tr:eq('+index+') td:eq(3)').html('<b class="text-success">Success</b>');
//            }else{
//                $('#tablePhone tbody tr:eq('+index+') td:eq(3)').html('<b class="text-danger">Failed</b>');
//            }
            var percent = parseInt(index)*100/max;
            showPercent(Math.ceil(percent));
            index++;
            setTimeout(function(){
                regEvent();
            },100);
        }, 'json')
    }

    function showPercent(number){
        $('#process').css('width', number+'%');
        $('#percent').html(number+'%');
    }

    function getPassword(id){
        $.post('incoming.php?act=getPassword', {
            id:id
        }, function(result){
            s=prompt('Mật khẩu của user:',result.password);
        },'json')
    }
</script>






