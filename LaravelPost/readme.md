===================
upload server

===================
bulid up
- sail php artisan make:migration create_plg_posts_table --path=packages/Phonglg/LaravelPost/database/migrations
- sail php artisan make:migration create_plg_threads_table --path=packages/Phonglg/LaravelPost/database/migrations
- sail php artisan make:migration create_plg_post_thread_table --path=packages/Phonglg/LaravelPost/database/migrations
- sail php artisan make:migration create_plg_post_related_table --path=packages/Phonglg/LaravelPost/database/migrations


# LaravelPost

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelpost
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelpost.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelpost.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelpost/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelpost
[link-downloads]: https://packagist.org/packages/phonglg/laravelpost
[link-travis]: https://travis-ci.org/phonglg/laravelpost
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
