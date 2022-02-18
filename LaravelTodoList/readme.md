Build 
- sail php artisan packager:new Phonglg LaravelTodoList --i
- sail composer require phonglg/laraveltodolist
- create migration
+ sail php artisan make:migration create_plg_todo_lists_table --path=packages/Phonglg/LaravelTodoList/database/migrations
- create factories-> update package: sail composer update vendor/phonglg 


# LaravelTodoList

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laraveltodolist
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laraveltodolist.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laraveltodolist.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laraveltodolist/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laraveltodolist
[link-downloads]: https://packagist.org/packages/phonglg/laraveltodolist
[link-travis]: https://travis-ci.org/phonglg/laraveltodolist
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
