var serverinfo = {
    host:"192.168.10.254",
    port:3000
};
var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server,{ log: false });
server.listen(serverinfo.port,serverinfo.host);
console.log("Server listening in: "+serverinfo.host+":"+serverinfo.port);
app.get('/',function(req,res){
    res.sendfile(__dirname + '/index.html');
});

io.sockets.on('connection', function (socket) {
    socket.on('adduser', function(obj){
        if(obj.uid != undefined){
            socket.uid = obj.uid;
            socket.username = obj.username;
            socket.join(obj.uid);
            console.log(socket.username+" logged");
        }
    });
    socket.on('disconnect', function(){
        socket.leave(socket.uid);
        console.log(socket.username+" out");
    });
    socket.on('sendnotify', function(obj){
        console.log(obj);
        io.sockets.in(obj.sendto).emit('newnotify',obj);
    });
});

