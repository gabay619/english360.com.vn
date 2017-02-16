<?php
$title = "Quản lý nội dung từ điển";
$categorycl = $dbmg->category;
$newscl = $dbmg->tudien;
#condition
$catid = $_GET['catid'];
if (!isset($catid)) $catid = "";
$alphabetical = $_GET['alpha'];
if (!isset($alphabetical)) $alphabetical = "";
$limit = 25;
$p = $_GET['p'];
if ($p <= 1) $p = 1;
$cp = ($p - 1) * $limit;
$stpage = $p;
$q = $_GET['q'];
if (isset($q)) {
    $cond = array('$or' => array(array('key' => new MongoRegex("/$q/iu")), array('_id' => "$q"), array('value' => new MongoRegex("/$q/iu"))));
}
else $cond = array();
$sort = array("value" => 1);

?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
    <div class="col-xs-12 text-left nopadding">
        <div class="col-xs-1 nopadding">Chuyên mục</div>
        <div class="col-xs-11">
            <a href="<?php echo cpagerparm("catid,status,id") ?>catid=" class="<?php echo $catid == "" ? "text-danger" : "" ?>">Tất cả chuyên mục
                &nbsp;&nbsp;&nbsp;</a>
            <?php
            $listcat = iterator_to_array($categorycl->find(array("type" => "tudien"), array("_id", "name")), false);
            foreach ($listcat as $key => $i) {
//                if ($catid <= 0 && $key <= 0) $catid = $i['_id'];
                ?>
                <a href="<?php echo cpagerparm("catid,status,id") ?>catid=<?php echo $i['_id'] ?>" class="<?php echo $catid == $i['_id'] ? "text-danger" : "" ?>"><?php echo $i['name'] ?>
                    &nbsp;&nbsp;&nbsp;</a>
            <?php } ?>
        </div>
    </div>
    <div class="col-xs-12 text-left row">
        <div class="col-xs-1 nopadding">Chữ cái</div>
        <div class="col-xs-11">
            <a href="<?php echo cpagerparm("alpha,status,id") ?>alpha=" class="<?php echo $alphabetical == "" ? "text-danger" : "" ?>">...
                &nbsp;&nbsp;&nbsp;</a>
            <?php foreach (range('A', 'Z') as $i) { ?>
                <a href="<?php echo cpagerparm("alpha,status,id") ?>alpha=<?php echo $i ?>" class="<?php echo $alphabetical == $i ? "text-danger" : "" ?>"><?php echo $i ?>
                    &nbsp;&nbsp;&nbsp;</a>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="text-right row">
        <div class="col-xs-3 text-left">
            <?php if (acceptpermiss("tudien_insert")) { ?>
            <a href="<?php echo cpagerparm("tact,id,status") ?>tact=tudien_insert">Thêm mới</a><?php } ?>
        </div>
        <div class="col-xs-4 right">
            <form action="" method="get">
                <?php foreach ($_GET as $key => $val) if (!in_array($key, array("q", "status", "id", "p"))) { ?>
                    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                        <input type="text" placeholder="Tiêu đề hoặc mã" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;
                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                </th>
                <th>Key</th>
                <th>Từ</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
//            print_r($catid);die;
            if(!empty($catid))
                $cond['catid'] = $catid;
            if(!empty($alphabetical))
                $cond['key'] = $alphabetical;
            $cursor = $newscl->find($cond)->sort($sort);
            $rowcount = $cursor->count();
            $listnews = $cursor->skip($cp)->limit($limit);
            foreach ($listnews as $item) { ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td><?php echo $item['key'] ?></td>
                    <td><?php echo $item['value'] ?></td>
                    <td><?php echo date("d-m-Y H:i:s", $item['_id']) ?></td>
                    <td>
                        <?php if (acceptpermiss("tudien_update")) { ?>
                            <a href="<?php echo cpagerparm("tact,status,id") ?>tact=tudien_update&id=<?php echo $item['_id'] ?>">
                                Sửa</a> |<?php } ?>
                        <?php if (acceptpermiss("tudien_delete")) { ?>
                        <a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=tudien_delete&id=<?php echo $item['_id'] ?>">
                                Xóa</a><?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<?php include("component/paging.php") ?>