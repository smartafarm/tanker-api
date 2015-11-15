var io = require('socket.io').listen(8080);
io.sockets.on('connection', function (socket) {
    socket.on('clientMessage', function(content, name) {
    socket.broadcast.emit('serverMessage', name + ' said: ' + content);
    });
});