<?php
$title = "Quản lý trình độ";
//$categorycl = $dbmg->category;
//$newscl = $dbmg->nguphap;
//$usercl = $dbmg->user;
$levelcl = $dbmg->test_level;
#condition
//$limit = 25;
//$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
//$q = $_GET['q'];
$cond = array();
//if(!empty($q)){
//    $cond = array(
//        '$or'=>array(
//            array('namenonutf'=>new MongoRegex("/$q/iu")),
//            array('_id'=>"$q")
//        )
//    );
//}
//if(!empty($_GET['level'])){
//    $cond['level'] = intval($_GET['level']);
//}
//if(!empty($_GET['type'])){
//    $cond['type'] = $_GET['type'];
//}

//print_r($cond);
$sort = array("datecreate" => -1);
$cursor = $levelcl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor;
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="row">
        <div class="col-xs-3" style="margin-bottom: 15px">
            <a href="<?php echo cpagerparm("tact,id,status") ?>tact=test_level_insert">Thêm mới</a>
        </div>
    </div>

    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=test_level_delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                <th>Điểm</th>
                <th>Trình độ</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listnews as $item) {
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td><?php echo $item['start'].'-'.$item['end'] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="<?php echo cpagerparm("tact,status,id") ?>tact=test_level_update&id=<?php echo $item['_id'] ?>">Sửa</a>
                        <a class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=test_level_delete&id=<?php echo $item['_id'] ?>">Xóa</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
