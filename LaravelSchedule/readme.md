==========================================
- Your task schedule is defined in the app/Console/Kernel.php file's schedule method.
- run schedule: sail php artisan schedule:work
* * * * * cd /home/thantai/domains/thantai39.vn/public_html && php artisan schedule:run >> /dev/null 2>&1
==========================================
# LaravelSchedule

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelschedule
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

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelschedule.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelschedule.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelschedule/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelschedule
[link-downloads]: https://packagist.org/packages/phonglg/laravelschedule
[link-travis]: https://travis-ci.org/phonglg/laravelschedule
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
