<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
$aff_txncl = $dbmg->aff_txn;
$title = "Quản lý publisher";
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$cond = array('account_balance'=>array('$exists' => true));
if(!empty($_GET['email'])){
//    $user = $usercl->findOne(array('email'=>$_GET['email']));
//    if($user)
    $cond['email'] = $_GET['email'];
}
$startdate = '01/02/2017';
$enddate = date('d/m/Y');
//$convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
//$convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
//$cond['datecreate'] = array(
//    '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
//    '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
//);

//$list = $aff_txncl->aggregate(array(
//    array('$match' => $cond),
//    array('$group' => array('_id'=>'$uid', 'sum_discount'=>array('$sum'=>'$discount'),'count'=>array('$sum'=>1))),
//    array('$sort' => array('sum_discount'=>-1)),
//    array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
//    array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
//));
$sort = array('account_balance'=>-1);
$rowcount = $usercl->count($cond);
$list = $usercl->find($cond)->sort($sort)->limit($limit)->skip($cp);

//$rowcount = isset($list['result'][0]['total']) ? $list['result'][0]['total'] : 0;
//$list = isset($list['result'][0]['data']) ? $list['result'][0]['data'] : array();
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
<!--                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="--><?php //echo $startdate ?><!--">-->
<!--                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="--><?php //echo $enddate ?><!--">-->
                <input type="submit" class="btn btn-primary" value="Tìm">
            </div>
        </form>

    </div>
</div>
<table class="table table-hover text-left">
    <thead>
    <tr>
        <th>Email</th>
        <th>Số dư</th>
        <th>Đóng băng</th>
        <th>Chiết khấu</th>
        <th>Trạng thái</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $key=>$item):
//        $user = $usercl->findOne(array('_id'=>$item['_id']));
//        $lastChat = $item['chat'][count($item['chat']) - 1];
        $discount = isset($item['aff_discount']) ? $item['aff_discount'] : Constant::AFF_RATE_CARD;
        ?>
        <tr>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo number_format($item['account_balance']); ?></td>
            <td><?php echo number_format($item['account_seal_balance']); ?></td>
            <td>
                <?php echo number_format($discount*100); ?>%
                <button type="button" class="btn btn-sm btn-default" onclick="changeDiscount('<?php echo $item['_id'] ?>')"><i class="glyphicon glyphicon-edit"></i></button>
            </td>
            <td>
                <?php if($item['aff_status'] == Constant::STATUS_DISABLE): ?>
                    <b class="text-danger">Bị khóa</b>
                <?php  else:  ?>
                    <b class="text-success">Hoạt động</b>
                <?php endif; ?>
            </td>
            <td>
                <?php if($item['aff_status'] == Constant::STATUS_DISABLE): ?>
                    <button type="button" class="btn btn-sm btn-success" onclick="unlock('<?php echo $item['_id'] ?>')"><i class="fa fa-unlock-alt"></i></button>
                <?php  else:  ?>
                    <button type="button" class="btn btn-sm btn-danger" onclick="lock('<?php echo $item['_id'] ?>')"><i class="fa fa-lock"></i></button>
                <?php endif; ?>
                <button type="button" class="btn btn-sm btn-primary" onclick="getDetail('<?php echo $item['_id'] ?>','<?php echo $item['email']; ?>')">Chi tiết</button>
                <?php if($item['account_balance'] >= Constant::WITHDRAW_MIN_PAY): ?>
                <button type="button" class="btn btn-sm btn-info" onclick="withdraw('<?php echo $item['_id'] ?>',<?php echo $item['account_balance'] ?>)">Rút tiền</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include("component/paging.php") ?>
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chi tiết <span></span></h4>
            </div>
            <div class="modal-body">
<!--                <p><strong class="daterange"></strong></p>-->
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Click</th>
                        <th>Lượt thanh toán</th>
                        <th>Hiệu suất</th>
                        <th>Tổng doanh thu</th>
                        <th>Khách hàng</th>
                        <th>Chiết khấu</th>
                        <th>Số dư</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="click"></td>
                        <td class="count-revenue"></td>
                        <td class="rate"></td>
                        <td class="revenue"></td>
                        <td class="count-user"></td>
                        <td class="discount"></td>
                        <td class="balance"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function getDetail(id,email) {
//        $('#myModal .daterange').html('<?php //echo $startdate ?>// - <?php //echo $enddate ?>//');
        $('#myModal .modal-title').html(email);
        $.post('incoming.php?act=getAffDetail', {
            id:id, start:'<?php echo $startdate ?>', end: '<?php echo $enddate ?>'
        }, function (re) {
            $('#myModal .click').html(re.click);
            $('#myModal .count-revenue').html(re.count_revenue);
            $('#myModal .rate').html(re.rate);
            $('#myModal .revenue').html(re.revenue);
            $('#myModal .count-user').html(re.user);
            $('#myModal .discount').html(re.discount+'<button type="button" class="btn btn-sm btn-default" onclick="changeDiscount('+id+')"><i class="glyphicon glyphicon-edit"></i></button>');
            $('#myModal .balance').html(re.balance);
//            alert(JSON.stringify(re, null, 4));
        });
        $('#myModal').modal('show');
    }

    function changeDiscount(id) {
        discount = prompt('Nhập mức chiết khấu mới (%)');
        if(discount > 0){
            $.post('incoming.php?act=changeDiscount', {
                id:id, discount:discount
            }, function (re) {
                if(re.success){
                    alert('Success!');
                    location.reload();
                }else{
                    alert('Failed!');
                }
            });
        }
    }

    function withdraw(id,max) {
        amount = prompt('Nhập số tiền cần rút (ít nhất <?php echo number_format(Constant::WITHDRAW_MIN_PAY) ?>vnđ)',max);
        if(amount>0){
            $.post('incoming.php?act=withdraw', {
                id:id, amount:amount
            },function (re) {
                if(re.success){
                    alert('Tạo lệnh rút tiền thành công');
                    location.reload();
                }else{
                    alert(re.mss);
                }
            });
        }
    }

    function lock(id) {
       if(confirm('Khoá publisher này?')) {
           $.post('incoming.php?act=lockPub', {
               id:id
           }, function (re) {
               if(re.success){
                   alert('Khóa thành công');
                   location.reload();
               }else{
                   alert(re.mss);
               }
           })
       }
    }

    function unlock(id) {
        if(confirm('Mở khoá publisher này?')) {
            $.post('incoming.php?act=unlockPub', {
                id:id
            }, function (re) {
                if(re.success){
                    alert('Mở thành công');
                    location.reload();
                }else{
                    alert(re.mss);
                }
            })
        }
    }
</script>
