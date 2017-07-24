<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$title = "Thêm tài khoản Event Đồng hành cùng HSSV";
$userCl = $dbmg->user;
$id = $_GET['id'];

?>
<script type="text/javascript" src="plugin/tinymce/jquery.tinymce.js"></script>
<link rel="stylesheet" href="asset/css/jquery-ui.css">
<script src="asset/js/jquery-ui.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>tact=hssv_view">Thoát</a></div>
<?php
#Post Process
if (isset($_POST['acpt'])) {
//    print_r($_POST);die;
    $redirect = $_POST['redirect'];
    unset($_POST['redirect']);
    unset($_POST['acpt']);
//    $_POST['namenonutf'] = convert_vi_to_en($_POST['username']);
    if (!empty($_POST['un_password'])){
//        $_POST['un_password'] = $_POST['password'];
        $_POST['password'] = Common::encryptpassword($_POST['password']);
    }
    else unset($_POST['password']);

    if ($tact == "hssv_insert") {

//        print_r($_POST);die;
//        $userObject = (object) $userCl->findOne(array("username"=>$_POST['username']));
//        if (!$userObject->_id) {
            if (!empty($_POST['phone']))
                $userObject = $userCl->findOne(array("phone"=>$_POST['phone']));
//        print_r($userObject);die;
            if (!$userObject) {
                if(empty($_POST['un_password'])){
                    if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=error");
                }
//                print_r($_POST);die;
                $_POST['_id'] = strval(time());
                $_POST['datecreate'] = time();
                $_POST['password'] = Common::encryptpassword($_POST['un_password']);
                $_POST['priavatar'] = '';
                $_POST['cmnd'] = '';
                $_POST['cmnd_noicap'] = '';
                $_POST['cmnd_ngaycap'] = '';
                $_POST['displayname'] = '';

                $_POST['status']= Constant::STATUS_ENABLE;
                $_POST['event'] = Event::HOC_SINH_SINH_VIEN;
                $_POST['thong_bao'] = array(
                    'noti' => "1",
                    'sms' => "1",
                    'email' => "1",
                );
//                print_r($_POST);die;
                $result = $userCl->insert($_POST);
            } else {
                $update = array(
                    'email' => $_POST['email'],
//                    'un_password' => $_POST['un_password'],
//                    'password' => Common::encryptpassword($_POST['un_password']),
                    'birthday' => $_POST['birthday'],
                    'event' => Event::HOC_SINH_SINH_VIEN
                );
                $userCl->update(array('phone'=>$_POST['phone']), array('$set'=>$update), array("upsert" => false));
            }
//        } else {
//            $status = "error";
//            $errorMesssage = "Đã có người dùng với username này";
//        }
    }
    else {
//        $_POST['password'] = Common::encryptpassword($_POST['un_password']);
        $result = $userCl->update(array("_id" => "$id"), array('$set' => $_POST), array("upsert" => false));
    }
    if (!isset($status)) {
        if ($redirect != 1) header("Location: " . cpagerparm("status,id,tact") . "status=success");
        else header("Location: " . cpagerparm("status") . "status=success");
    }
}
##Get Data
if ($tact != "hssv_insert") $_POST = (array)$userCl->findOne(array("_id" => "$id"));
?>
<?php include("component/message.php"); ?>
<form class="form-horizontal" role="form" action="" method="post">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active"><a href="#info" role="tab" data-toggle="tab">Thông tin người dùng</a></li>
        <!--    <li><a href="#category" role="tab" data-toggle="tab">Phân quyền</a></li>-->
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <p>&nbsp;</p>
            <input type="hidden" name="acpt" value="1" />
            <!--<div class="form-group">
        <label class="col-sm-2 control-label">Chức vụ</label>

        <div class="col-sm-10">
            <select type="text" name="country" class="form-control">
            <?php /*foreach($countryList as $elem) { */?>
                <option value="<?php /*echo $elem['key'] */?>" <?php /*if ($elem['key']==$_POST['country']) echo 'selected="selected"' */?>> <?php /*echo $elem['name'] */?> </option>
            <?php /*} */?>
            </select>
        </div>
    </div>-->
            <div class="form-group">
                <label class="col-sm-2 control-label">Số điện thoại</label>

                <div class="col-sm-10">
                    <input type="text" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?>" placeholder="Số điện thoại">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="text" name="un_password" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" value="<?php echo $_POST['email'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Ngày sinh</label>
                <div class="col-sm-10">
                    <input type="text" name="birthday" class="form-control datepicker" value="<?php echo $_POST['birthday'] ?>">
                </div>
            </div>


            <!--    <div class="form-group">
                    <label class="col-sm-2 control-label">Mở rộng</label>

                    <div class="col-sm-10">
                        <label>
                            <input type="radio" class="col-sm-1" value="hot" name="isstatus" />&nbsp;Hot
                        </label> |
                        <label>
                            <input type="radio" class="col-sm-1" value="new" name="isstatus" /> &nbsp;Mới
                        </label> |
                        <label>
                            <input type="radio" class="col-sm-1" value="none" name="isstatus" /> &nbsp;Không gì cả
                        </label>
                    </div>
                </div>-->
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
<script>
    $(function () {
        $('#checkallcat').click(function () {
            if ($(this).is(':checked')) $('.catitem:not(:disabled)').prop('checked', true);
            else $('.catitem:not(:disabled)').prop('checked', false);
        });
    });
</script>
<script>
    $(function () {
        $("#listimage").sortable();
        $("#listimage").disableSelection();
    });
</script>