============================
Instal extension for VsCode
REST Client
============================
# API laravel: 
https://laravel.com/docs/5.8/api-authentication
https://laravel.com/docs/8.x/sanctum
============================
Install
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
composer require phonglg/laravelapi
in ...app\Http\Kernel.php: \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
call API in: ...\packages\Phonglg\LaravelApi\CallAPI.http
============================
> Call API
- Header -> add key: Accept -> value: application/json => "message": "Unauthenticated."
> register
- http://127.0.0.1:8000/api/register; method POST
- Header -> add key: Accept -> value: application/json
- body-> x-www-form: enter email, password, username.... => have token
* have to: password_confirmation 
> use token to access
- tab Authorization -> type: Bearer Token: enter token above
url Test:
- http://127.0.0.1:8000/api/demo
- http://127.0.0.1:8000/api/logout

- http://127.0.0.1:8000/api/register
- http://127.0.0.1:8000/api/login

==================
# LaravelApi

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelapi
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelapi.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelapi.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelapi/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelapi
[link-downloads]: https://packagist.org/packages/phonglg/laravelapi
[link-travis]: https://travis-ci.org/phonglg/laravelapi
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
