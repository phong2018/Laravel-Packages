
=====================================
Using
sail php artisan test

=====================================
Build up
https://laravel.com/docs/8.x/packages#a-note-on-facades
https://github.com/orchestral/testbench
- sail php artisan packager:new Phonglg LaravelTest --i

- ** in phpunit.xml in root project
<directory suffix="Test.php">./vendor/phonglg/laraveltest/tests/Unit</directory>  
<directory suffix="Test.php">./vendor/phonglg/laraveltest/tests/Feature</directory>
- **** laravel801\composer.json: because: autoload-dev (root only)
"autoload-dev": {"psr-4": {...."Phonglg\\LaravelSelfCreated\\Tests\\": "vendor/phonglg/laravelselfcreated/tests"}},

- sail composer update vendor/phonglg
- sail composer dump-autoload
- sail php artisan test
- sail php ./vendor/bin/testbench package:test
- sail php ./vendor/bin/testbench package:test --parallel

=====================================
# LaravelTest

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laraveltest
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laraveltest.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laraveltest.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laraveltest/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laraveltest
[link-downloads]: https://packagist.org/packages/phonglg/laraveltest
[link-travis]: https://travis-ci.org/phonglg/laraveltest
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
