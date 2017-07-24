<?php
$title = "Quản lý SlideShow";
//$categorycl = $dbmg->category;
//$newscl = $dbmg->nguphap;
$usercl = $dbmg->user;
$slidecl = $dbmg->slide;
#condition
$limit = 25;
$p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
$cond = array();

//print_r($cond);
$sort = array("datecreate" => -1);
$cursor = $slidecl->find($cond)->sort($sort);
$rowcount = $cursor->count();
$listslides = $cursor->skip($cp)->limit($limit);
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div class="row">
        <div class="col-xs-3" style="margin-bottom: 15px">
            <?php if(acceptpermiss("slide_insert")) { ?><a href="<?php echo cpagerparm("tact,id,status") ?>tact=slide_insert">Thêm mới</a><?php }?>
        </div>
    </div>

    <form action="<?php echo cpagerparm("tact,id,status") ?>tact=slide_delete" method="post">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"><input type="checkbox" id="checkall" />&nbsp;<button type="submit" class="btn btn-sm btn-danger">Xóa</button></th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Trạng thái</th>
                <th style="width: 100px">Người tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listslides as $item) {
                $user = $usercl->findOne(array('_id'=>$item['usercreate'] ),array('username'));
                ?>
                <tr>
                    <td><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $item['_id'] ?>" /></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><img src="<?php echo $item['avatar'] ?>" alt="" style="width: 200px"></td>
                    <td>
                        <a href="javascript:void(0)" onclick="tooggleChangeStatus(this)"><span id="item_status_<?php echo $item['_id'] ?>"><?php echo $item['status'] === "0" ?  "Ẩn": "Hiện"; ?></span></a>
                        <div class="box_change_status" style="display: none" id="box_change_<?php echo $item['_id'] ?>">
                            <div><a href="javascript:void(0)" onclick="changeStatus(<?php echo $item['_id']?>, 0)">Ẩn</a></div>
                            <div><a href="javascript:void(0)" onclick="changeStatus(<?php echo $item['_id']?>, 1)">Hiện</a></div>
                        </div>
                    </td>
                    <td><?php echo $user['username'] ?></td>
                    <td>
                        <?php if(acceptpermiss("slide_update")) { ?><a class="btn btn-sm btn-primary" href="<?php echo cpagerparm("tact,status,id") ?>tact=slide_update&id=<?php echo $item['_id'] ?>">Sửa</a><?php }?>
                        <?php if(acceptpermiss("slide_delete")) { ?><a class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=slide_delete&id=<?php echo $item['_id'] ?>">Xóa</a><?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
    <script>
        function changeStatus (atid, status) {
            var isUpdateTime = confirm("Bạn có muốn cập nhật lại thời gian không");
            $.post('incoming.php',{act: 'changestatusslide', atid: atid, status: status, isUpdateTime: isUpdateTime}, function(res) {
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
    </script>
<?php include("component/paging.php") ?>