=========================================================
Install
php artisan vendor:publish -> select number: Phonglg\LaravelUserRole\LaravelVesoServiceProvider


=========================================================
Build Processs
sail php artisan make:migration create_veso_prizes_table --path=packages/Phonglg/LaravelVeso/database/migrations
sail php artisan make:migration create_veso_products_table --path=packages/Phonglg/LaravelVeso/database/migrations
sail php artisan make:migration create_veso_orders_table --path=packages/Phonglg/LaravelVeso/database/migrations
sail php artisan make:migration create_veso_order_product_table --path=packages/Phonglg/LaravelVeso/database/migrations


=========================================================
# LaravelVeso

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelveso
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test

Install:
sail composer require --dev "orchestra/testbench=^6.0"
sail composer dump-autoload 
sail php artisan config:clear
sail php artisan cache:clear
in root project: 
    <directory suffix="Test.php">./packages/Phonglg/LaravelVeso/tests/Unit</directory> 
    <directory suffix="Test.php">./packages/Phonglg/LaravelVeso/tests/Feature</directory>
      <server name="APP_ENV" value="testing"/>
        <server name="BCRYPT_ROUNDS" value="4"/>
        <server name="CACHE_DRIVER" value="array"/>
        <server name="DB_CONNECTION" value="mysql"/>
        <server name="DB_HOST" value="mysql"/>
        <server name="DB_PORT" value="3306"/>
        <server name="DB_DATABASE" value="laravelveso"/>
        <server name="DB_USERNAME" value="sail"/>
        <server name="DB_PASSWORD" value="password"/>
        <server name="MAIL_MAILER" value="array"/>
        <server name="QUEUE_CONNECTION" value="sync"/>
        <server name="SESSION_DRIVER" value="array"/>
        <server name="TELESCOPE_ENABLED" value="false"/>
        
sail php artisan test

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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelveso.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelveso.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelveso/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelveso
[link-downloads]: https://packagist.org/packages/phonglg/laravelveso
[link-travis]: https://travis-ci.org/phonglg/laravelveso
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
