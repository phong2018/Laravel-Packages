
===========================
INSTALL
- composer require phonglg/laraveluserrole
- php artisan vendor:publish -> select number: Phonglg\LaravelUserRole\LaravelUserRoleServiceProvider
-> create file: laravelpackages\config\laraveluserrole.php 
- seed admin data:
+ php artisan db:seed --class='Phonglg\LaravelUserRole\Database\Seeders\LaravelUserRoleSeeder'
*** note: to use seeder: add composer.json: - "autoload": { "psr-4": {....
    "Phonglg\\LaravelUserRole\\Database\\Seeders\\": "database/seeders/"
- add: role_id for User model: app\Models\User.php

===========================
# LaravelUserRole

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laraveluserrole
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laraveluserrole.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laraveluserrole.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laraveluserrole/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laraveluserrole
[link-downloads]: https://packagist.org/packages/phonglg/laraveluserrole
[link-travis]: https://travis-ci.org/phonglg/laraveluserrole
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
