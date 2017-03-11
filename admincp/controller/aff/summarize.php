<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
$aff_txncl = $dbmg->aff_txn;
$title = "Sản lượng từ publisher";
#condition
$cond = array();
if(!empty($_GET['email'])){
    $user = $usercl->findOne(array('email'=>$_GET['email']));
    if($user)
        $cond['uid'] = $user['_id'];
}
$startdate = isset($_GET['start']) ? $_GET['start'] : date('01/m/Y');
$enddate = isset($_GET['end']) ? $_GET['end'] : date('d/m/Y');
$convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
$convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
$cond['datecreate'] = array(
    '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
    '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
);

//print_r($rowcount);

$list = $aff_txncl->aggregate(array(
    array('$match' => $cond),
    array('$group' => array('_id'=>'$method', 'sum_discount'=>array('$sum'=>'$discount'),'count'=>array('$sum'=>1),'sum_amount'=>array('$sum'=>'$amount'))),
));

$list = isset($list['result']) ? $list['result'] : array();

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
                <input type="text" placeholder="Email:" name="email" class="form-control" value="<?php echo $_GET['email'] ?>">
                <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $startdate ?>">
                <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $enddate ?>">
                <input type="submit" class="btn btn-primary" value="Tìm">
            </div>
        </form>
    </div>
</div>
<div class="row" style="margin-top: 20px">
    <div class="col-sm-6">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>Loại</th>
                <th>Số lượt thanh toán</th>
                <th>Doanh thu</th>
                <th>Chiết khấu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $item):
//                $user = $usercl->findOne(array('_id'=>$item['_id']));
                ?>
                <tr>
                    <td><?php echo Common::getPaymentMethod($item['_id'])?></td>
                    <td><?php echo $item['count']?></td>
                    <td><?php echo number_format($item['sum_amount'])?></td>
                    <td><?php echo number_format($item['sum_discount'])?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <div class="flot-chart">
            <div class="flot-chart-content" id="flot-pie-chart"></div>
        </div>
    </div>
</div>
<style>
    .flot-chart {
        display: block;
        height: 400px;
    }
    .flot-chart-content {
        width: 100%;
        height: 100%;
    }
</style>
<script>
    $(function () {
        var data = [
                <?php foreach($list as $item): ?>
        {
            label: "<?php echo Common::getPaymentMethod($item['_id'])?>",
                data: <?php echo $item['sum_discount'] ?>
        },
        <?php  endforeach ?>
        ];
        $.plot('#flot-pie-chart', data, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            },
            grid: {
                hoverable: true
            },
        });
    })


    function labelFormatter(label, series) {
        return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }

</script>
<!-- Flot Charts JavaScript -->
<!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
<script src="/assets/lib/flot/jquery.flot.js"></script>
<script src="/assets/lib/flot/jquery.flot.tooltip.min.js"></script>
<script src="/assets/lib/flot/jquery.flot.resize.js"></script>
<script src="/assets/lib/flot/jquery.flot.pie.js"></script>
