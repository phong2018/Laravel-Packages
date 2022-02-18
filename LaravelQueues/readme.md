================
Install
composer require phonglg/laravelqueues
php artisan queue:table
php artisan migrate
php artisan queue:work
*** in .env # disable queue: QUEUE_CONNECTION=database
================ 
queued job
https://laravel.com/docs/8.x/queues
https://www.youtube.com/watch?v=y2A-zcwHo4g&t=2s
- laravel8\config\queue.php
- php artisan queue:table
- php artisan migrate
- php artisan make:job SendEmailWhenLikePost ->  laravel8\app\Jobs\SendEmailWhenLikePost.php
- sail php artisan queue:work
*** in .env # disable queue: QUEUE_CONNECTION=database

# LaravelQueues

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelqueues
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelqueues.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelqueues.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelqueues/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelqueues
[link-downloads]: https://packagist.org/packages/phonglg/laravelqueues
[link-travis]: https://travis-ci.org/phonglg/laravelqueues
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
