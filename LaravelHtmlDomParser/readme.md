==========================================
Install
- sail composer require voku/simple_html_dom
- sail composer require phonglg/laravelhtmldomparser
- Your task schedule is defined in the app/Console/Kernel.php file's schedule method.
+ $schedule->command('veso:getdata')->everyMinute();
- sail php artisan veso:getdata
* run schedule
- sail php artisan schedule:work

* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

crontab -e
* * * * * cd /home/thantai/public_html && php artisan schedule:run >> /dev/null 2>&1 
/home/thantai/public_html

==========================================
Guide:
https://github.com/voku/simple_html_dom
Laravel HTML DOM Parser: LaravelHtmlDomParser
https://simplehtmldom.sourceforge.io/
https://packagist.org/packages/dimabdc/php-fast-simple-html-dom-parser

==========================================
# LaravelHtmlDomParser

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelhtmldomparser
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

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelhtmldomparser.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelhtmldomparser.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelhtmldomparser/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelhtmldomparser
[link-downloads]: https://packagist.org/packages/phonglg/laravelhtmldomparser
[link-travis]: https://travis-ci.org/phonglg/laravelhtmldomparser
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
