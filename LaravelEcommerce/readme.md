- composer require bumbummen99/shoppingcart
- composer require phonglg/laravelecommerce
- composer remove phonglg/laravelecommerce
- php artisan migrate
- php artisan db:seed --class='Phonglg\LaravelEcommerce\Database\Seeders\LaravelEcommerceSeeder'
* to configure config for taxRate
- php artisan vendor:publish --provider="Gloudemans\Shoppingcart\ShoppingcartServiceProvider" --tag="config"


-----------guide
https://packagist.org/packages/bumbummen99/shoppingcart

https://www.larashout.com/laravel-e-commerce-application-development-checkout
https://github.com/conedevelopment/bazar
https://www.youtube.com/watch?v=FiC4rUYi27w&t=320s

- add ship: https://viblo.asia/p/su-dung-api-giao-hang-nhanh-de-tinh-gia-cuoc-van-chuyen-1Je5EQB45nL
-------------use package
- cart package: https://github.com/bumbummen99/LaravelShoppingcart
- dont load all page by:
+ use live-wire: https://laravel-livewire.com/docs/2.x/quickstart
+ or use Ajax, jquery...


# LaravelEcommerce

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelecommerce
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelecommerce.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelecommerce.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelecommerce/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelecommerce
[link-downloads]: https://packagist.org/packages/phonglg/laravelecommerce
[link-travis]: https://travis-ci.org/phonglg/laravelecommerce
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
