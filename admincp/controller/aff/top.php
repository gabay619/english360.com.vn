<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
$aff_txncl = $dbmg->aff_txn;
$affclickcl = $dbmg->aff_click;
$title = "Top publisher";
#condition
$limit = 10;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
//$q = $_GET['q'];
$cond = array();
//if(!empty($_GET['email'])){
//    $user = $usercl->findOne(array('email'=>$_GET['email']));
//    if($user)
//        $cond['uid'] = $user['_id'];
//}
$startdate = isset($_GET['start']) ? $_GET['start'] : date('01/m/Y');
$enddate = isset($_GET['end']) ? $_GET['end'] : date('d/m/Y');
$convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
$convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
$cond['datecreate'] = array(
    '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
    '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
);

$topClick = $affclickcl->aggregate(array(
    array('$match' => $cond),
    array('$group' => array('_id'=>'$uid', 'numclick'=>array('$sum'=>1))),
    array('$sort' => array('numclick'=>-1)),
    array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
    array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
));
$rowcount = isset($topClick['result'][0]['total']) ? $topClick['result'][0]['total'] : 0;
$topClick = isset($topClick['result'][0]['data']) ? $topClick['result'][0]['data'] : array();
//print_r($rowcount);

$condUser = array(
    'aff.datecreate' => $cond['datecreate'],
    'status' => Constant::STATUS_ENABLE
);
$topUser = $usercl->aggregate(array(
    array('$match' => $condUser),
    array('$group' => array('_id'=>'$aff.uid', 'num_user'=>array('$sum'=>1))),
    array('$sort' => array('num_user'=>-1)),
    array('$limit' => $limit),
    array('$skip' => $cp)
//    array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
//    array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
));
$topUser = isset($topUser['result']) ? $topUser['result'] : array();

$topRevenue = $aff_txncl->aggregate(array(
    array('$match' => $cond),
    array('$group' => array('_id'=>'$uid', 'sum_discount'=>array('$sum'=>'$discount'),'count'=>array('$sum'=>1))),
    array('$sort' => array('sum_discount'=>-1)),
    array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
    array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
));

$topRevenue = isset($topRevenue['result'][0]['data']) ? $topRevenue['result'][0]['data'] : array();
//$list = $aff_txncl->aggregate(array(
//    array('$match' => $cond),
//    array('$group' => array('_id'=>'$uid', 'sum_discount'=>array('$sum'=>'$discount'),'count'=>array('$sum'=>1))),
//    array('$sort' => array('sum_discount'=>-1)),
//    array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
//    array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit)))),
//));
//
//$rowcount = $list['result'][0]['total'];
//$list = $list['result'][0]['data'];
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
                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $startdate ?>">
                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $enddate ?>">
                <input type="submit" class="btn btn-primary" value="Tìm">
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <h2>Top Doanh thu</h2>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>Publisher</th>
                <th>Doanh thu</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($topRevenue as $item):
                $user = $usercl->findOne(array('_id'=>$item['_id']));
                ?>
                <tr>
                    <td><?php echo $user['email']?></td>
                    <td><?php echo number_format($item['sum_discount'])?></td>
                    <td><button type="button" class="btn btn-sm btn-primary" onclick="getDetail('<?php echo $item['_id'] ?>','<?php echo $user['email']; ?>')">Chi tiết</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4">
        <h2>Top Click</h2>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>Publisher</th>
                <th>Click</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($topClick as $item):
                $user = $usercl->findOne(array('_id'=>$item['_id']));
                ?>
            <tr>
                <td><?php echo $user['email']?></td>
                <td><?php echo $item['numclick']?></td>
                <td><button type="button" class="btn btn-sm btn-primary" onclick="getDetail('<?php echo $item['_id'] ?>','<?php echo $user['email']; ?>')">Chi tiết</button></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4">
        <h2>Top User</h2>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>Publisher</th>
                <th>User</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($topUser as $item):
                $user = $usercl->findOne(array('_id'=>$item['_id']));
                ?>
                <tr>
                    <td><?php echo $user['email']?></td>
                    <td><?php echo $item['num_user']?></td>
                    <td><button type="button" class="btn btn-sm btn-primary" onclick="getDetail('<?php echo $item['_id'] ?>','<?php echo $user['email']; ?>')">Chi tiết</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("component/paging.php") ?>
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chi tiết <span></span></h4>
            </div>
            <div class="modal-body">
                <p><strong class="daterange"></strong></p>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Click</th>
                        <th>Lượt thanh toán</th>
                        <th>Hiệu suất</th>
                        <th>Doanh thu</th>
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
        $('#myModal .daterange').html('<?php echo $startdate ?> - <?php echo $enddate ?>');
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
                    alert('Tạo lệnh rút tiền thành công')
                }else{
                    alert(re.mss);
                }
            });
        }
    }
</script>
