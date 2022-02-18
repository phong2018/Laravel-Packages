------------USE Laravel websocket
laravel-websockets
https://beyondco.de/docs/laravel-websockets/getting-started/introduction
http://127.0.0.1:8000/laravel-websockets

1. install websockets: https://beyondco.de/docs/laravel-websockets/getting-started/installation
+ composer require beyondcode/laravel-websockets
+ php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
+ php artisan migrate
+ php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
+ 'path' => 'laravel-websockets',

2. pusher replace
+ composer require pusher/pusher-php-server "~3.0"
+ .env: BROADCAST_DRIVER=pusher
+ Pusher Configuration: config/broadcasting.php: following: https://beyondco.de/docs/laravel-websockets/basic-usage/pusher
+ Configuring WebSocket Apps: config/websockets.php
*** turn on: App\Providers\BroadcastServiceProvider::class:: \\wsl$\Ubuntu-20.04\home\source\laravel801\config\app.php :: 174
+ Starting the WebSocket server: 
*** add to docker-compose.xml in laravel.test/port: - '${LARAVEL_WEBSOCKETS_PORT:-6001}:${LARAVEL_WEBSOCKETS_PORT:-6001}'
*** run server: sail php artisan websockets:serve 
3. make event
4. create frontend listen Event
+ config listen: https://beyondco.de/docs/laravel-websockets/basic-usage/ssl
+ install js: npm install --save-dev laravel-echo pusher-js
+ use laravel-echo: https://laravel.com/docs/8.x/broadcasting
* If you customize the broadcast name using the broadcastAs method, you should make sure to register your listener with a leading . character. This will instruct Echo to not prepend the application's namespace to the event:

--------install package LaravelSockets
1- sail php artisan packager:new Phonglg LaravelSockets --i
2- composer require phonglg/laravelsockets
-------- 

# LaravelSockets

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelsockets
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Author Name][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelsockets.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelsockets.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelsockets/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelsockets
[link-downloads]: https://packagist.org/packages/phonglg/laravelsockets
[link-travis]: https://travis-ci.org/phonglg/laravelsockets
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
