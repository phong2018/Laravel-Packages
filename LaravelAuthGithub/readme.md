=========================================
INSTALL
- insall https://laravel.com/docs/8.x/socialite: composer require laravel/socialite
- composer require phonglg/laravelauthgithub
- php artisan vendor:publish -> select number: Phonglg\LaravelAuthGithub\LaravelAuthGithubServiceProvider
-> create file: laravelpackages\config\laravelauthgithub.php -> to option client_id, client_secret...
- link use: http://127.0.0.1:8000/github/loginPage

- configure in github:
+ Homepage URL: http://127.0.0.1:8000
+ Authorization callback URL: http://127.0.0.1:8000/github/callback
=========================================
# LaravelAuthGithub

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelauthgithub
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelauthgithub.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelauthgithub.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelauthgithub/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelauthgithub
[link-downloads]: https://packagist.org/packages/phonglg/laravelauthgithub
[link-travis]: https://travis-ci.org/phonglg/laravelauthgithub
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
