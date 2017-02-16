<script src="http://192.168.10.254:3000/socket.io/socket.io.js"></script>
<script>
    var userid = "111";
    var userdisplayname = "BOT";
    var socket = io.connect('http://192.168.10.254:3000');
    // on connection to server, ask for user's name with an anonymous callback
    socket.on('connect', function () {
        // call the server-side function 'adduser' and send one parameter (value of prompt)
        var obj = { uid: userid, username: userdisplayname, device: 'wap' };
        socket.emit('adduser', obj);
    });
    // Tesst send data
    var obj = { sendto: '1421813589', fromid: userid,fromname:userdisplayname, device: 'web' };
    socket.emit('sendnotify', obj);
</script>