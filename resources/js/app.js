import Echo from 'laravel-echo';

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    key: '36dd2e5f89e425a928bd1c37936323a9',
    transports: ['websocket', 'polling', 'flashsocket'] // Fix CORS error!
});
