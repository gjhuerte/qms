var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var dotenv = require('dotenv').config()

redis.subscribe('queue-channel', function(err, count) {
});

redis.subscribe('attended-queue', function(err, count) {
});

redis.subscribe('call-channel', function(err, count) {
});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(process.env.SOCKET_PORT, function(){
    console.log('Listening on Port ' + process.env.SOCKET_PORT);
});

redis.on("call", function(channel, data) {
	socket.emit(channel, data);
});