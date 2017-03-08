<?php
$title = "Quản lý lệnh rút tiền";
$withdrawcl = $dbmg->withdraw;
$usercl = $dbmg->user;

//$newscl = $dbmg->news;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array();

if(!empty($_GET['email'])){
    $user = $usercl->findOne(array('email'=>$_GET['email']));
    if($user)
        $cond['uid'] = $user['_id'];
}
$startdate = $_GET['start'];
if(!empty($startdate)){
    $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
    $cond['datecreate']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
}
$enddate = $_GET['end'];
if(!empty($enddate)){
    $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
    $cond['datecreate']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
}
if(!empty($_GET['status'])){
    $cond['status'] = intval($_GET['status']);
}
$sort = array("datecreate" => -1);
//print_r($cond);
$cursor = $withdrawcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$list = $cursor->skip($cp)->limit($limit);
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="row">
    <div class="col-xs-12">
        <form action="" method="get" class="form-inline">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <input type="text" placeholder="Email" name="email" value="<?php echo $_GET['email'] ?>" class="form-control">
                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $_GET['start'] ?>">
                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $_GET['end'] ?>">
                <select name="status" class="form-control">
                    <option value="">--Trạng thái--</option>
                    <option value="<?php echo Constant::WITHDRAW_STATUS_NEW ?>" <?php if($_GET['status']==Constant::WITHDRAW_STATUS_NEW ) echo 'selected' ?>>Chờ duyệt</option>
                    <option value="<?php echo Constant::WITHDRAW_STATUS_COMPLETE ?>" <?php if($_GET['status']==Constant::WITHDRAW_STATUS_COMPLETE ) echo 'selected' ?>>Hoàn thành</option>
                    <option value="<?php echo Constant::WITHDRAW_STATUS_CANCEL ?>" <?php if($_GET['status']==Constant::WITHDRAW_STATUS_CANCEL ) echo 'selected' ?>>Đã hủy</option>
                </select>
                <input type="submit" class="btn btn-primary" value="Tìm">
            </div>
        </form>

    </div>
</div>
<table class="table table-hover table-bordered" style="margin-top: 15px">
    <thead>
    <tr>
        <!--                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
<!--        <th>ID</th>-->
        <th>User</th>
        <th>Số tiền</th>
        <th>Ngân hàng</th>
        <th>Tên TK</th>
        <th>Số TK</th>
        <th>Người tạo</th>
        <th>Thời gian tạo</th>
        <th>Trạng thái</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $item) {
        $user = $usercl->findOne(array('_id'=>$item['uid']));
        $usercreate = $usercl->findOne(array('_id'=>$item['u_create']));
        switch ($item['status']){
            case Constant::WITHDRAW_STATUS_COMPLETE:
                $class = 'text-success';
                break;
            case Constant::WITHDRAW_STATUS_CANCEL:
                $class = 'text-danger';
                break;
            default:
                $class = 'text-info';
                break;
        }
        ?>
        <tr>
<!--            <td>--><?php //echo $item['_id'] ?><!--</td>-->
            <td><?php echo $user['email'] ?></td>
            <td><?php echo number_format($item['amount']) ?></td>
            <td><?php echo Common::getAllBank()[$item['bank']['id']] ?> - <?php echo $item['bank']['branch'] ?></td>
            <td><?php echo $item['bank']['account_name'] ?></td>
            <td><?php echo $item['bank']['account_number'] ?></td>
            <td><?php echo $usercreate['username'] ?></td>
            <td><?php echo date("d-m-Y H:i", $item['datecreate']) ?></td>
            <td><b class="<?php echo $class ?>"><?php echo Common::getWithdrawStatus($item['status'])?></b></td>
            <td>
                <?php if($item['status'] == Constant::WITHDRAW_STATUS_NEW): ?>
                <button class="btn btn-success btn-sm" type="button" onclick="completeWithdraw('<?php echo $item['_id'] ?>')">Hoàn thành</button>
                <button class="btn btn-danger btn-sm" type="button" onclick="cancelWithdraw('<?php echo $item['_id'] ?>')">Hủy</button>
                <?php endif;?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php include("component/paging.php") ?>
<script>
    function completeWithdraw(id) {
        if(confirm('Bạn đã hoàn thành lệnh rút tiền này?')){
            $.post('incoming.php?act=completeWithdraw', {
                id:id
            }, function (re) {
                if(re.success){
                    alert(re.mss);
                    location.reload();
                }else{
                    alert(re.mss);
                }
            })
        }
    }
    
    function cancelWithdraw(id) {
        if(confirm('Bạn muốn hủy lệnh rút tiền này?')){
            $.post('incoming.php?act=cancelWithdraw', {
                id:id
            }, function (re) {
                if(re.success){
                    alert(re.mss);
                    location.reload();
                }else{
                    alert(re.mss);
                }
            })
        }
    }
</script>
