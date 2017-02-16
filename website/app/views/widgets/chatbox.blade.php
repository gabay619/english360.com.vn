<script src="{{Constant::BASE_URL}}:3000/socket.io/socket.io.js"></script>
<link href="/assets/lib/chatbox/chat.css" rel="stylesheet">
<!-- shoutbox -->
<!--<div class="chat-box">-->
<div class="shout_box">
    <div class="shout_box_header">
        Chat với chúng tôi <div class="close_btn">&nbsp;</div>
    </div>
    <div class="toggle_chat" style="display: none">
        <div class="message_box" id="message_box">
            @if($allChat)
            @foreach($allChat->chat as $item)
            <div class='shout_msg'>
                <time>{{date('H:i', $item['time'])}}</time>
                <span class="username">{{$item['name']}}</span>
                <span class="message">{{$item['text']}}</span>
            </div>
            @endforeach
            @endif
        </div>
        <div class="user_info">
            <input name="shout_message" id="txtChat" placeholder="Chat và nhấn Enter" maxlength="200" />
        </div>
    </div>
</div>

<!--</div>-->
<!-- shoutbox end -->

<!--<div class="chat-box">-->
<!--    <div id="khung" style="width: 100%; height: 250px;overflow-y: scroll;">-->
<!--        --><?php //if($allChat):
//        foreach($allChat->chat as $item):?>
        <!--        <span>(--><?php //echo date('H:i', $item['time']) ?><!--)</span>-->
<!--        <strong>--><?php //echo $item['name'] ?><!--</strong> :-->
<!--        <span>--><?php //echo $item['text']?><!--</span><br>-->
<!--        --><?php //endforeach;
//        endif;
//        ?>
        <!--    </div>-->
<!--    <input id="txtChat" /><button onclick="sendChat();">Gui</button>-->
<!--</div>-->

<script>
    var socket = io('{{str_replace('http','ws',Constant::BASE_URL) }}:3000', { transports: ['websocket'] });
    var ssid = '{{$sessionId}}';
    socket.on('connect', function() {
        console.log("Ok");
    });
    function sendChat(){
        $.post('/ajax/alert-chat', {}, function(re){}, 'json');
        var name = '{{Auth::user() ? Auth::user()->getDisplayName() : 'Khách'}}';
        var text = $('#txtChat').val();
        socket.emit('chat',{mss:text, ssid: ssid, name: name, type: 'user'});
        $('#txtChat').val('');
    }
    $(function(){
        $('#txtChat').keypress(function(e){
            if(e.which==13 && $(this).val() != ''){
                sendChat();
            }
        });

        //toggle hide/show shout box
        $(".shout_box .shout_box_header").click(function (e) {
            //get CSS display state of .toggle_chat element
            var toggleState = $('.toggle_chat').css('display');

            //toggle show/hide chat box
            $('.toggle_chat').slideToggle(200);

            //use toggleState var to change close/open icon image
            if(toggleState == 'block')
            {
                $(".shout_box .shout_box_header div").attr('class', 'open_btn');
            }else{
                $(".shout_box .shout_box_header div").attr('class', 'close_btn');
                $('#message_box').animate({scrollTop: $('#message_box').prop('scrollHeight')}, 200);
            }
        });
    })



    socket.on('chat_response',function(data){
        var currentTime = new Date();
        var hour = currentTime.getHours() < 10 ? "0"+currentTime.getHours()  : currentTime.getHours();
        var min = currentTime.getMinutes() < 10 ? "0"+currentTime.getMinutes() : currentTime.getMinutes();
        content = '<div class="shout_msg">'+
                '<time>'+hour+':'+min+'</time>'+
                '<span class="username">'+data.name+'</span>'+
                '<span class="message">'+data.mss+'</span>'+
                '</div>';
        if(data.ssid == ssid){
            $('#message_box').append(content);
            $('#message_box').animate({scrollTop: $('#message_box').prop('scrollHeight')}, 200);
        }
    })
</script>
<style>
    .shout_box{
        position: fixed; right: 50px; bottom: 0; width: 250px;
        /*background: #fff;*/
        /*padding: 10px;*/
    }
</style>