import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: 'gariin.com',
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    disableStats: true,
});