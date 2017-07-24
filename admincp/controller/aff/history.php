<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
$aff_txncl = $dbmg->aff_txn;
$title = "Lịch sử giao dịch publisher";
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
if(!empty($_GET['ref_email'])){
    $ref_user = $usercl->findOne(array('email'=>$_GET['ref_email']));
    if($ref_user)
        $cond['ref_id'] = $ref_user['_id'];
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
$sort = array('datecreate'=>-1);
$rowcount = $aff_txncl->count($cond);
$list = $aff_txncl->find($cond)->sort($sort)->limit($limit)->skip($cp);

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
                <input type="text" placeholder="User Email" name="ref_email" value="<?php echo $_GET['ref_email'] ?>" class="form-control">
                <input type="text" placeholder="Publisher Email" name="email" value="<?php echo $_GET['email'] ?>" class="form-control">
                <!--                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="--><?php //echo $startdate ?><!--">-->
                <!--                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="--><?php //echo $enddate ?><!--">-->
                <input type="submit" class="btn btn-primary" value="Tìm">
                <?php     if(acceptpermiss("aff_pub")): ?>
                <a href="javascript:addTrans()" class="btn btn-info">Thêm giao dịch chuyển khoản</a>
                <?php endif; ?>
            </div>
        </form>

    </div>
</div>
<table class="table table-hover text-left">
    <thead>
    <tr>
        <th>User</th>
        <th>Publisher</th>
        <th>Số tiền</th>
        <th>Chiết khấu</th>
        <th>Loại</th>
        <th>Thời gian</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $key=>$item):
        $user = $usercl->findOne(array('_id'=>$item['uid']));
        $ref_user = $usercl->findOne(array('_id'=>$item['ref_id']));
//        $lastChat = $item['chat'][count($item['chat']) - 1];
//        $discount = isset($item['aff_discount']) ? $item['aff_discount'] : Constant::AFF_RATE_CARD;
        ?>
        <tr>
            <td><?php echo $ref_user['email']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo number_format($item['amount']); ?></td>
            <td><?php echo number_format($item['discount']); ?></td>
            <td><?php echo Common::getPaymentMethod($item['method']); ?></td>
            <td><?php echo date('d/m/Y H:i',$item['datecreate']); ?></td>
            <td>
                <?php if(acceptpermiss("aff_pub") && $item['method'] == Constant::CHUYENKHOAN_METHOD_NAME): ?>
                <button class="btn btn-sm btn-danger" onclick="deleteTrans('<?php echo $item['_id'] ?>')">Xóa</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="modal fade" id="addTransModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Thêm giao dịch</h4>
            </div>
            <div class="modal-body">
                <form>
                    <p id="modalAjaxMss" class="text-danger" style="display: none"></p>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Email khách hàng:</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Publisher:</label>
                        <input type="text" class="form-control" id="publisher" disabled>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Số tiền:</label>
                        <input type="text" class="form-control" id="amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="saveTrans()">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script>
    function addTrans(){
        $('#addTransModal').modal('show');
    }
    
    function saveTrans() {
        user_email = $('#email').val();
        amount = $('#amount').val();
        $.post('incoming.php?act=addTrans', {
            email: user_email, amount: amount
        }, function(re){
            if(re.success){
                location.reload();
            }else{
                $('#modalAjaxMss').show().html(re.mss);
            }
        })

    }

    function deleteTrans(id) {
        if(confirm('Bạn muốn xóa giao dịch này?')){
            $.post('incoming.php?act=deleteTrans', {
                id:id
            }, function (re) {
                if(re.success){
                    location.reload();
                }else
                    alert(re.mss);
            })
        }
    }

    $(function () {
        $('#email').change(function () {
            user_email = $(this).val();
            $.post('incoming.php?act=checkPublisher', {
                email:user_email
            }, function (re) {
                if(re.success){
                    $('#publisher').val(re.email);
                }else{
                    $('#publisher').val('');
                    $('#modalAjaxMss').show().html(re.mss);
                }
            })
        })
    })
</script>
<?php include("component/paging.php") ?>
