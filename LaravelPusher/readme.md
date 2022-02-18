
==================
install: "pusher/pusher-php-server": composer require pusher/pusher-php-server
$ composer require phonglg/laravelpusher
** laravel801\config\broadcasting.php:
 'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => false, 
            ],
        ],
//==================
# LaravelPusher

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelpusher
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelpusher.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelpusher.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelpusher/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelpusher
[link-downloads]: https://packagist.org/packages/phonglg/laravelpusher
[link-travis]: https://travis-ci.org/phonglg/laravelpusher
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
