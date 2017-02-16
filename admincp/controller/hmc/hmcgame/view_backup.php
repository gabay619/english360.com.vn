<?php
$title = "Danh sách Game";
$categorycl = $dbmg->category;
$newscl = $dbmg->hmcgame;
$usercl = $dbmg->user;
$catid = $_GET['catid'];
#condition
$limit = 25;
$p = $_GET['p'];
if ($p <= 1) $p = 1;
$cp = ($p - 1) * $limit;
$stpage = $p;
$q = $_GET['q'];
if (isset($q)) {
    $cond = array('$or' => array(array('namenonutf' => new MongoRegex("/$q/iu")), array('_id' => "$q")));
}
else $cond = array();
$sort = array("_id" => -1);
$cursor = $newscl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor->skip($cp)->limit($limit);
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="text-right row">
        <div class="col-xs-3 text-left">
            <?php if (acceptpermiss("hmcgame_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=hmcgame_insert">Thêm mới</a><?php } ?>
        </div>
        <div class="col-xs-4 right">
            <form action="" method="get">
                <?php foreach ($_GET as $key => $val) if (!in_array($key, array("q", "status", "id", "p"))) { ?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                        <input type="text" placeholder="Tiêu đề hoặc mã tin" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
                    </div>
                </div>
        </div>
        </form>
    </div>
    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;
                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                </th>
                <th>Ảnh</th>
                <th>Câu trả lời</th>
                <th>Chuyên mục</th>
                <th>Người tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listnews as $item) {
                $user = $usercl->findOne(array('_id'=>$item['usercreate'] ),array('username'));
                $userup = $usercl->findOne(array('_id'=>$item['userupdate']),array('username'));
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td class="col-md-2"><img src="<?php echo $item['avatar'] ?>" class="img-thumbnail" style="max-width: 120px;" /></td>
                    <td><?php echo $item['aw'] ?> </td>
                    <td>
                        <ul>
                            <?php
                            if (count($item['category']) <= 0) $item['category'] = array();
                            $lcatcursor = $categorycl->find(array("_id" => array('$in' => $item['category'])), array("_id", "name"));
                            foreach ($lcatcursor as $cat) echo '<li title="' . $cat['_id'] . '">- ' . $cat['name'] . '</li>';
                            ?>
                        </ul>
                    </td>
                    <td><?php echo $user['username'] ?></td>
                    <td>
                        <?php if (acceptpermiss("hmcgame_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=hmcgame_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php } ?>
                        <?php if (acceptpermiss("hmcgame_update")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=hmcgame_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>