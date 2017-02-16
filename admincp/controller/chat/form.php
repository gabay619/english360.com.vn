<?php
$title = "Trả lời chat";
$chatcl = $dbmg->chat;
$id = $_GET['id'];
$item = $chatcl->findOne(array('ssid'=>$id));
?>
<script src="<?php echo Constant::BASE_URL ?>:3000/socket.io/socket.io.js"></script>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<div class="text-left"><a href="<?php echo cpagerparm("tact,id") ?>">Thoát</a></div>
<?php include("component/message.php"); ?>

<div>
    <div class="col-sm-8" style="height: 300px; border: 1px solid #ddd; overflow-y: scroll; margin-bottom: 15px" id="khung">
        <?php foreach($item['chat'] as $aChat):?>
            <span>(<?php echo date('H:i', $aChat['time']) ?>)</span>
            <strong><?php echo $aChat['name'] ?></strong> :
            <span><?php echo $aChat['text']?></span><br>
        <?php endforeach; ?>
    </div>
    <div class="form-group col-sm-8">
        <input type="text" class="form-control" autofocus placeholder="Nhập chat..." id="txtChat" style="margin-bottom: 15px"/>
        <button onclick="chat();" class="btn btn-primary pull-right">Chat</button>
        <div style="clear: both"></div>
    </div>
</div>

<script>
    var socket = io('<?php echo str_replace('http','ws',Constant::BASE_URL) ?>:3000', { transports: ['websocket'] });
    var ssid = '<?php echo $item['ssid'] ?>';
    socket.on('connect', function() {
        console.log('Ok');
    });
    function chat(){
        var name = 'Hỗ trợ';
        var text = $('#txtChat').val();
        socket.emit('chat',{mss:text, ssid: ssid, name: name, type: 'admin'});
        $('#txtChat').val('');
    }
    $(function(){
        $('#txtChat').keypress(function(e){
            if(e.which==13){
                chat();
            }
        });
        $('#khung').animate({scrollTop: $('#khung').prop('scrollHeight')}, 200);
    })

    socket.on('chat_response',function(data){
        var currentTime = new Date();
        var hour = currentTime.getHours() < 10 ? '0'+currentTime.getHours()  : currentTime.getHours();
        var min = currentTime.getMinutes() < 10 ? '0'+currentTime.getMinutes() : currentTime.getMinutes();
        content = '<span>('+hour+':'+min+')</span> '+
            '<strong>'+data.name+'</strong>: '+
            '<span>'+data.mss+'</span>';
        if(data.ssid == ssid){
            $('#khung').append(content+'<br>');
            $('#khung').animate({scrollTop: $('#khung').prop('scrollHeight')}, 200);
        }

    });
</script>