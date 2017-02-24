<?php
$title = "Quản lý giao dịch ngân hàng";
$txncl = $dbmg->txn_bank;
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
if(!empty($startdate)){
    $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
    $cond['datecreate']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
}
if(!empty($enddate)){
    $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
    $cond['datecreate']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
}
if(!empty($_GET['response_code'])){
    if($_GET['response_code'] == '1'){
        $cond['response_code'] = Constant::TXN_BANK_SUCCESS;
    }else if($_GET['response_code'] == '3'){
        $cond['response_code'] = Constant::TXN_BANK_PENDING;
    }else{
        $cond['response_code'] = array('$nin'=>array(Constant::TXN_BANK_SUCCESS, Constant::TXN_BANK_PENDING));
    }
//    $cond['card_type'] = $_GET['card_type'];
}
//if(isset($q)){
//    $cond = array(
//        '$or'=>array(
//            array('namenonutf'=>new MongoRegex("/$q/iu")),
//            array('_id'=>"$q")
//        )
//    );
//}
//else $cond = array();
$sort = array("datecreate" => -1);
$cursor = $txncl->find($cond)->sort($sort);
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
                <select name="response_code" class="form-control">
                    <option value="">--Trạng thái--</option>
                    <option value="1" <?php if($_GET['response_code']=='1') echo 'selected' ?>>Thành công</option>
                    <option value="2" <?php if($_GET['response_code']=='2') echo 'selected' ?>>Thất bại</option>
                    <option value="3" <?php if($_GET['response_code']=='3') echo 'selected' ?>>Đang chờ</option>
                </select>
                <input type="submit" class="btn btn-primary" value="Tìm">
            </div>
        </form>

    </div>
</div>
    <table class="table table-hover">
        <thead>
        <tr>
            <!--                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>-->
            <th>ID</th>
            <th>User</th>
            <th>Số tiền</th>
            <th>Ngân hàng</th>
            <th>Thời gian</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $item) {
            $user = $usercl->findOne(array('_id'=>$item['uid']));
            ?>
            <tr>
                <!--                    <td><input type="checkbox" class="checkitem" name="id[]" value="--><?php //echo $item['_id'] ?><!--" /></td>-->
                <!--                    <td class="col-md-2"><img src="--><?php //echo $item['avatar'] ?><!--" class="img-thumbnail" style="max-width: 120px;" /></td>-->
                <td><?php echo $item['_id'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo number_format($item['amount']) ?></td>
                <td><?php echo isset($item['card_type']) ? $item['card_type'] : $item['card_type'] ?></td>
                <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
                <td><?php echo $item['response_code'] == Constant::TXN_BANK_SUCCESS ? '<b class="text-success">Thành công</b>' : ($item['response_code'] == Constant::TXN_BANK_PENDING ? '<b class="text-info">Chờ xử lý</b>' : '<b class="text-danger">Thất bại</b>')  ?></td>
                <td>
                    <button class="btn btn-default btn-sm" onclick="getLog('<?php echo $item['_id']?>')" type="button">Log</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php include("component/paging.php") ?>
<script>
    function getLog(id) {
        $.post('incoming.php?act=getLogBank', {
            id:id
        }, function (re) {
            alert(JSON.stringify(re, null, 4));
        })
    }
</script>