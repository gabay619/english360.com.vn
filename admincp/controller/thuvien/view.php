<?php
$title = "Quản lý thư viện bài viết";
$categorycl = $dbmg->category;
$newscl = $dbmg->thuvien;
$usercl = $dbmg->user;
$catid = $_GET['catid'];
$type = $categorycl->findOne(array('_id'=>$catid))['type'];
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$q = $_GET['q'];
$username = $_GET['uname'];
$startdate = $_GET['start'];
$enddate = $_GET['end'];
$cond = array();
if(isset($q)){
    $cond = array(
        '$or'=>array(
                array('namenonutf'=>new MongoRegex("/".Common::vietnameseToEnglish($q)."/iu")),
                array('_id'=>"$q")
        )
    );
}
if(isset($username) && !empty($username)){
    $user = $usercl->findOne(array('username'=>$username));
    if($user)
        $cond['usercreate'] = $user['_id'];
}
if(isset($startdate) && !empty($startdate)){
    $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
    $cond['datecreate']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
}
if(isset($enddate) && !empty($enddate)){
    $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
    $cond['datecreate']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
}
if(isset($_GET['free'])){
    if($_GET['free'] == '1'){
        $cond['free'] = '1';
    }else if($_GET['free'] === '0'){
        $cond['free'] = array('$ne'=>'1');
    }
}
$cond['category'] = array('$in'=>array($_GET['catid']));
$sort = array("datecreate" => -1);
$cursor = $newscl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listnews = $cursor->skip($cp)->limit($limit);
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<div class="row">
<div class="col-xs-3" style="margin-bottom: 15px">
<?php if(acceptpermiss("thuvien_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=thuvien_insert">Thêm mới</a><?php }?>
    | <a href="<?php echo cpagerparm("tact,id,status") ?>">Quay lại</a>
</div>

<div class="col-xs-12">
<form action="" method="get" class="form-inline">
    <?php foreach($_GET as $key=>$val) if(!in_array($key,array("q","status","id","p"))) {?> <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>" /> <?php } ?>
    <div class="form-group">
        <input type="text" placeholder="Tiêu đề hoặc mã" name="q" value="<?php echo $_GET['q'] ?>" class="form-control">
        <input type="text" placeholder="Người đăng" name="uname" value="<?php echo $_GET['uname'] ?>" class="form-control">
        <input type="text" placeholder="Từ ngày:" name="start" class="form-control datepicker" value="<?php echo $_GET['start'] ?>">
        <input type="text" placeholder="Đến ngày:" name="end" class="form-control datepicker" value="<?php echo $_GET['end'] ?>">
        <select name="free" class="form-control">
            <option value="">--Chọn miễn phí--</option>
            <option value="1" <?php if($_GET['free']=='1') echo 'selected' ?>>Có</option>
            <option value="0" <?php if($_GET['free']==='0') echo 'selected' ?>>Không</option>
        </select>
        <input type="submit" class="btn btn-primary" value="Tìm">
      </div>
</form>
</div>
</div>
<form action="<?php echo cpagerparm("tact,id,status") ?>tact=delete" method="post">
<table class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1">
            <input type="checkbox" id="checkall" />&nbsp;
            <?php if(acceptpermiss("thuvien_delete")) {?>
            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
            <?php } ?>
        </th>
        <th>Ảnh</th>
        <th>Tiêu đề</th>
        <th>Chuyên mục</th>
        <th style="width: 100px">Người tạo</th>
        <th>Thao tác</th>
        <th>Miễn phí</th>
        <th>Ngày tạo</th>
        <th>Đánh giá</th>
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
            <td><a href="<?php echo Constant::BASE_URL.'/'.Common::getCateSlugByType($type).'/'.Common::utf8_to_url($item['name']).'-'.$item['_id'].'.html?source=admin' ?>" target="_blank"><?php echo $item['name'] ?></a>
                <p class="text-muted">Mã: <?php echo $item['_id'] ?></p>
            </td>
            <td>
                <ul>
                    <?php
                    if(count($item['category'])<=0) $item['category'] = array();
                    $lcatcursor = $categorycl->find(array("_id"=>array('$in'=>$item['category'])),array("_id","name"));
                    foreach($lcatcursor as $cat) echo '<li title="'.$cat['_id'].'">- '.$cat['name'].'</li>';
                    ?>
                </ul>
            </td>
            <td><?php echo $user['username'] ?>
                <p class="text-muted user_update"><?php echo $userup['username'] ?></p>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="tooggleChangeStatus(this)"><span id="item_status_<?php echo $item['_id'] ?>"><?php echo $item['status'] === "0" ?  "Ẩn": "Hiện"; ?></span></a>
                <div class="box_change_status" style="display: none" id="box_change_<?php echo $item['_id'] ?>">
                    <div><a href="javascript:void(0)" onclick="changeStatus(<?php echo $item['_id']?>, 0)">Ẩn</a></div>
                    <div><a href="javascript:void(0)" onclick="changeStatus(<?php echo $item['_id']?>, 1)">Hiện</a></div>
                </div>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="tooggleChangeFree(this)"><span id="item_free_<?php echo $item['_id'] ?>"><?php echo $item['free'] == "1" ?  "Có": "Không"; ?></span></a>
                <div class="box_change_status" style="display: none" id="box_change_free_<?php echo $item['_id'] ?>">
                    <div><a href="javascript:void(0)" onclick="changeFree(<?php echo $item['_id']?>, 0)">Không</a></div>
                    <div><a href="javascript:void(0)" onclick="changeFree(<?php echo $item['_id']?>, 1)">Có</a></div>
                </div>
            </td>
            <td><?php echo date("d-m-Y H:i:s", $item['datecreate']) ?></td>
            <td>
                <span class="text-success"><?php echo isset($item['review']['yes']) && is_array($item['review']['yes']) ? count($item['review']['yes']) : 0 ?></span> -
                <span class="text-danger"><?php echo isset($item['review']['no']) && is_array($item['review']['no']) ? count($item['review']['no']) : 0 ?></span>
            </td>
            <td>
                <?php if(acceptpermiss("thuvien_update")) { ?><a href="<?php echo cpagerparm("tact,status,id") ?>tact=thuvien_update&id=<?php echo $item['_id'] ?>">Sửa</a> |<?php }?>
                <?php if(acceptpermiss("thuvien_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=thuvien_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</form>
    <script>
        function changeStatus (atid, status) {
            var isUpdateTime = confirm("Bạn có muốn cập nhật lại thời gian không");
            $.post('incoming.php',{act: 'changestatus', atid: atid, status: status, isUpdateTime: isUpdateTime}, function(res) {
                if (res.status == 200) {
                    $("#box_change_"+atid).hide();
                    $("#item_status_"+atid).html(res.statusString);
                } else
                    alert(res.mss);
            });
        }
        function tooggleChangeStatus(obj) {
            $(obj).siblings().toggle();
        }
        function changeFree (atid, status) {
            $.post('incoming.php',{act: 'changefree', atid: atid, status: status, type: 'thuvien'}, function(res) {
                if (res.status == 200) {
                    $("#box_change_free_"+atid).hide();
                    $("#item_free_"+atid).html(res.statusString);
                } else
                    res.alert(res.mss);
            });
        }
        function tooggleChangeFree(obj) {
            $(obj).siblings().toggle();
        }


    </script>
<?php include("component/paging.php") ?>