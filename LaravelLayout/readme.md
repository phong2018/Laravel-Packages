==================
# use: asset
https://laravelpackage.com/09-routing.html#assets
php artisan vendor:publish --provider="Phonglg\LaravelLayout\LaravelLayoutServiceProvider" --tag="assets"
=> use:
<script src="{{ asset('laravellayout/js/app.js') }}"></script>
<link href="{{ asset('laravellayout/css/app.css') }}" rel="stylesheet" />

==================
# use laravel filemanger
https://unisharp.github.io/laravel-filemanager/installation
- edit in ....\config\filesystems.php
'url' => env('APP_URL').'/storage', 
=>
'url' => '/storage',
* Need run follow guide of laravel-filemanager
 php artisan vendor:publish --tag=lfm_config
 php artisan vendor:publish --tag=lfm_public
 php artisan storage:link
================== 
 # use laravel capchar
https://remotestack.io/laravel-captcha-example/
sail composer require mews/captcha  
sail php artisan vendor:publish -> select config
add: Route::get('/refresh-captcha', [FormController::class, 'refreshCaptcha']);
==================
# LaravelLayout

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravellayout
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravellayout.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravellayout.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravellayout/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravellayout
[link-downloads]: https://packagist.org/packages/phonglg/laravellayout
[link-travis]: https://travis-ci.org/phonglg/laravellayout
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
