==============
- install fortify in link: https://laravel.com/docs/8.x/fortify
- two factor authentification: https://laravel.com/docs/8.x/fortify#two-factor-authentication
- composer require phonglg/laravelfortify
- copy override folder \packages\Phonglg\LaravelFortify\Fortify to \app\Actions\Fortify 
- login by username: can change by username by in \config\fortify.php:: 49: 'username' => 'username',

==============
* Remove MustVerifyEmail
in \app\Models\User.php:: // implements MustVerifyEmail
# LaravelFortify

==============
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelfortify
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelfortify.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelfortify.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelfortify/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelfortify
[link-downloads]: https://packagist.org/packages/phonglg/laravelfortify
[link-travis]: https://travis-ci.org/phonglg/laravelfortify
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
