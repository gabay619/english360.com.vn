var config = require('./config/config.js'),logger = require('./config/logger.js');
var app = require('express')();
var http = require('http').Server(app);
http.listen(config.socketport, function(){});
// unserialize
var PHPUnserialize = require('php-unserialize');
//Socket
var io = require('socket.io')(http);
var redissocket = require('socket.io-redis');
io.adapter(redissocket({ host: config.redis_server.host, port: config.redis_server.port }));
// Init Redis
var redis = require('redis');
var redisconnect = redis.createClient(config.redis_server.port, config.redis_server.host);
redisconnect.on('connect', function() {
    logger.info('Redis',"connected");
});
app.get('/', function (req, res) {
    res.sendfile(__dirname + '/welcome.html');
});
logger.info('Server initilized on',config.socketport);
//************************************************************************


 //lets require/import the mongodb native drivers.
 var mongodb = require('mongodb');

 //We need to work with "MongoClient" interface in order to connect to a mongodb server.
 var MongoClient = mongodb.MongoClient;

 // Connection URL. This is where your mongodb server is running.
 var url = 'mongodb://localhost:27017/tagt';

/*
var MongoClient = require('mongodb').MongoClient;
var assert = require('assert');
//var url = 'mongodb://mkhoe:1234@localhost:27017/mkhoe';
MongoClient.connect(url, function(err, db) {
    assert.equal(null, err);
   /!* var collection = db.collection('bai_viet');
    collection.find().toArray(function(err, docs) {
        console.log(docs);
    });*!/
});
*/


io.sockets.on('connection', function(socket){
    socket.on('chat', function (data) {
        console.log('SOCKET ' + socket.id + ' chat message ' + JSON.stringify(data));
        saveChatToDb(data.mss, data.ssid, data.name, data.type);
        io.emit('chat_response', data);
    });

    socket.on('msfromclient', function (data) {
        redisconnect.get(config.redis_server.prefix+data.ssid+'_uinfo', function(err, reply) {
            reply = PHPUnserialize.unserialize(reply);
            if(reply!=null){
                var chatmss = {fullname:reply.fullname,mss:data.mss,uid:reply._id};
                console.log(chatmss);
                io.emit("msfromserver",chatmss);
            }
        });
    });

});

function saveChatToDb(text, ssid, name, type){
    // Use connect method to connect to the Server
    MongoClient.connect(url, function (err, db) {
        if (err) {
            console.log('Unable to connect to the mongoDB server. Error:', err);
            return false;
        } else {
            //HURRAY!! We are connected. :)
            logger.info('Connection established to', url);

            var collection = db.collection('chat');
            var datetime = Date.now() / 1000 | 0;
            collection.findOne({ssid: ssid}, function(err, result) {
                if(!result){
                    collection.insert({
                        ssid:ssid,
                        chat: [{
                            time: datetime,
                            text: text,
                            name: name,
                            type: type
                        }],
                        name: name,
                        time: datetime
                    });
                }else{
                    var newChat = result.chat;
                    newChat[result.chat.length] = {
                        time: datetime,
                        text: text,
                        name: name,
                        type: type
                    };
                    collection.update({ssid:ssid}, {$set :{chat: newChat, time: datetime}})
                }
            });
        }
    });
}
