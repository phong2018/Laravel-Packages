===========================  
- sail php artisan migrate
- composer require phonglg/laravelauth
- php artisan migrate
- add: username for User model: app\Models\User.php
==========================
use: Laravel Fortify: https://laravel.com/docs/8.x/fortify
- composer require laravel/fortify
- php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
=>
Copied File [/vendor/laravel/fortify/stubs/fortify.php] To [/config/fortify.php]
Copied File [/vendor/laravel/fortify/stubs/CreateNewUser.php] To [/app/Actions/Fortify/CreateNewUser.php]
Copied File [/vendor/laravel/fortify/stubs/FortifyServiceProvider.php] To [/app/Providers/FortifyServiceProvider.php]        
Copied File [/vendor/laravel/fortify/stubs/PasswordValidationRules.php] To [/app/Actions/Fortify/PasswordValidationRules.php]
Copied File [/vendor/laravel/fortify/stubs/ResetUserPassword.php] To [/app/Actions/Fortify/ResetUserPassword.php]
Copied File [/vendor/laravel/fortify/stubs/UpdateUserProfileInformation.php] To [/app/Actions/Fortify/UpdateUserProfileInformation.php]
Copied File [/vendor/laravel/fortify/stubs/UpdateUserPassword.php] To [/app/Actions/Fortify/UpdateUserPassword.php]
Copied Directory [/vendor/laravel/fortify/database/migrations] To [/database/migrations]
- php artisan migrate
- config for Fortify: laravel801\config\fortify.php
===========================
# LaravelAuth

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelauth
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelauth.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelauth.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelauth/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelauth
[link-downloads]: https://packagist.org/packages/phonglg/laravelauth
[link-travis]: https://travis-ci.org/phonglg/laravelauth
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
