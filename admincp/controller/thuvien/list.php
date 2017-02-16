<?php
$title = "Quản lý danh mục";
    $categorycl = $dbmg->category;
    $pid = $_GET['pid'];
    $thuvienId = $categorycl->findOne(['type'=>'thuvien', 'parentid'=>"0"])['_id'];
//    echo $pid;die;
//    var_dump($pid);die;
    $q = $_GET['q'];
    if (!isset($pid)) $pid = $thuvienId;
#condition
    $cond = array("parentid" => "$pid");
    if(isset($_GET['type']))
        $cond ["type"] = $_GET['type'];
    $sort = array("_id" => -1);
    if(isset($q) && strlen($q)>0) {
        unset($cond['parentid']);
        $q = convert_vi_to_en($q);
        $cond['namenoneutf'] = new MongoRegex("/$q/ui");
    }
    $listcat = iterator_to_array($categorycl->find($cond)->sort($sort));
    ?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
    <?php include "component/message.php"; ?>
    <div class="col-xs-3 text-left">
    <?php if(acceptpermiss("category_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=addnew"></a> <?php }?>
        </div>
    <div class="col-xs-4 right">
        <form action="" method="get">
            <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                    <input type="text" placeholder="Tên chuyên mục" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
                </div>
            </div>
        </form>
    </div>
    <table class="table table-hover text-left">
        <thead>
        <tr>
            <th>Mã</th>
            <th>Tên chuyên mục</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if (strlen($pid) > 0 && $pid!=$thuvienId) {
            $parrentobj = (object)$categorycl->findOne(array("_id" => "$pid"))
            ?>
            <tr>
                <td colspan="10" class="text-center">
                    <a href="<?php echo cpagerparm("pid") ?>pid=<?php echo $parrentobj->parentid ?>">(<?php echo $parrentobj->name ?>)...Up...</a></td>
            </tr>
        <?php }
        ?>
        <?php foreach ($listcat as $cat) { ?>
            <tr>
                <td><?php echo $cat['_id']; ?></td>
                <td><a href="<?php echo cpagerparm("act,tact,status,id") ?>act=thuvien&pid=<?php echo $cat['_id'] ?>"><?php echo $cat['name'] ?></a></td>
                <td><?php echo date("d-m-Y H:i:s", $cat['_id']) ?></td>
                <td>
                    <?php if(acceptpermiss("thuvien_view")) { ?><a href="<?php echo cpagerparm("act,tact,status,id,catid") ?>act=thuvien&tact=thuvien_view&catid=<?php echo $cat['_id'] ?>">Xem bài đăng</a><?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php include("component/paging.php") ?>