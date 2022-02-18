========================================
Install
- composer require phonglg/laravelnotifications
- php artisan notifications:table
- php artisan migrate
========================================
Notification
https://laravel.com/docs/8.x/notifications
https://www.youtube.com/watch?v=gtMXs9a1e0Y
- st1: php artisan make:notifications TestEnrollment
- st2: php artisan notifications:table
- st3: php artisan migrate
- st4: php artisan make:controller TestNoitification/TestEnrollment
ex: create SendNotificationsForAdmin


# LaravelNotifications

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelnotifications
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelnotifications.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelnotifications.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelnotifications/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelnotifications
[link-downloads]: https://packagist.org/packages/phonglg/laravelnotifications
[link-travis]: https://travis-ci.org/phonglg/laravelnotifications
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
