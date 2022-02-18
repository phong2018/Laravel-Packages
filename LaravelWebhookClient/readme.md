==================================================

==================================================
https://github.com/spatie/laravel-webhook-client
Build up:
1. composer require spatie/laravel-webhook-client
2. php artisan vendor:publish --provider="Spatie\WebhookClient\WebhookClientServiceProvider" --tag="webhook-client-config"
3. edit: config/webhook-client.php
'signing_secret' => env('WEBHOOK_CLIENT_SECRET'),
4. edit: .env: WEBHOOK_CLIENT_SECRET-> webhook server provide...
5. in config\webhook-client.php:  'process_webhook_job' => '',  This should be set to a class that extends \Spatie\WebhookClient\Jobs\ProcessWebhookJob.
6. php artisan vendor:publish --provider="Spatie\WebhookClient\WebhookClientServiceProvider" --tag="webhook-client-migrations"
7. php artisan migrate
8. add Route::webhooks('webhook-receiving-url'); in \routes\web.php
9. \app\Http\Middleware\VerifyCsrfToken.php : 'webhook-receiving-url',
10. config\webhook-client.php
11. clear all catch: sail php artisan optimize:clear
==================================================
# LaravelWebhookClient
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelwebhookclient
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

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelwebhookclient.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelwebhookclient.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelwebhookclient/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelwebhookclient
[link-downloads]: https://packagist.org/packages/phonglg/laravelwebhookclient
[link-travis]: https://travis-ci.org/phonglg/laravelwebhookclient
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
