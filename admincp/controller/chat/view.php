<?php
$chatcl = $dbmg->chat;
$title = "Quản lý chat";
#condition
$cond = array();
$sort = array("time" => -1);
$list = iterator_to_array($chatcl->find($cond)->sort($sort));
$countUnread = $chatcl->count(array('$where'=>'this.chat.length && this.chat[this.chat.length-1].type != "admin"'));
?>
<title><?php echo '('.$countUnread.') '.$title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="clearfix"></div>
<?php include "component/message.php"; ?>
<table class="table table-hover text-left">
    <thead>
    <tr>
        <th>Tên</th>
        <th>Thời gian</th>
        <th>Tin nhắn cuối</th>
        <th>Đã trả lời</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list as $key=>$item):
    $lastChat = $item['chat'][count($item['chat']) - 1];
    ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo date('d/m/Y H:i:s', $item['time'])?></td>
            <td><?php echo $lastChat['name']?>: <?php echo $lastChat['text']?></td>
            <td><?php echo (isset($lastChat['type']) && $lastChat['type'] == 'admin') ? '<b class="text-success">Rồi</b>' : '<b class="text-danger">Chưa</b>' ?></td>
            <td>
                <?php if(acceptpermiss("chat_update")) { ?><a target="_blank" href="<?php echo cpagerparm("tact,status,id") ?>tact=update&id=<?php echo $item['ssid'] ?>">Trả lời</a> |<?php } ?>
                <?php if(acceptpermiss("chat_delete")) { ?><a onclick="return confirm('Bạn chắc chắn chứ?')" href="<?php echo cpagerparm("tact,status,id") ?>tact=delete&id=<?php echo $item['ssid'] ?>">Xóa</a><?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script>
    $(function(){
        setTimeout(function(){
            location.reload();
        }, 10000);
    })
</script>