var userid = $('.useridinfo').attr('data-userid');
var userdisplayname = $('.useridinfo').attr('data-userdisplayname');
var socket = io.connect('http://192.168.10.254:3000');
// on connection to server, ask for user's name with an anonymous callback
socket.on('connect', function () {
    // call the server-side function 'adduser' and send one parameter (value of prompt)
    var obj = { uid: userid, username: userdisplayname, device: 'wap' };
    socket.emit('adduser', obj);
});
socket.on('newnotify', function (obj) {
    console.log(obj);
});