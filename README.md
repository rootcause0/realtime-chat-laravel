![npm](https://img.shields.io/npm/v/requirements?style=flat-square)
![php](https://img.shields.io/badge/php-%3E%3D8.0-blue)
![forks](https://img.shields.io/github/forks/rootcause0/realtime-chat-laravel?style=flat-square)
![license](https://img.shields.io/github/license/rootcause0/realtime-chat-laravel?style=flat-square)

# realtime-chat-laravel

A simple demonstration of Laravel Event Broadcasting feature with Pusher Channels on a real-time chat application.

Redis used as Queue Driver.</br>
You'll need 'phpredis' extension to run this app.

## Installation

- Clone the repository
- Make your way to the root path of the application and run


```bash
composer install
npm install
```

## Configuration
Configurate your .env keys shown below as follows

 ```bash
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=redis
PUSHER_APP_ID=YOUR_PUSHER_APP_ID
PUSHER_APP_KEY=YOUR_PUSHER_APP_KEY
PUSHER_APP_SECRET=YOUR_PUSHER_APP_SECRET
PUSHER_APP_CLUSTER=YOUR_PUSHER_APP_CLUSTER

```
## Running
Execute  ``` php artisan serve ``` and then ``` php artisan queue:work ```


## Contributing
Pull requests are welcome.


## License
[MIT](https://choosealicense.com/licenses/mit/)
