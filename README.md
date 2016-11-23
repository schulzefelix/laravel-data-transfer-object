# Super Charge A Data Transfer Object With Eloquent Magic

[![Latest Version](https://img.shields.io/github/release/schulzefelix/laravel-data-transfer-object.svg?style=flat-square)](https://github.com/schulzefelix/laravel-data-transfer-object/releases)
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![StyleCI](https://styleci.io/repos/74488171/shield)](https://styleci.io/repos/74488171)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Brings Laravel Attribute Casting and Date Mutators to objects.

## Install

Via Composer

``` bash
$ composer require schulzefelix/laravel-data-transfer-object
```

## Usage

``` php
$object = new DataTransferObject(['name' => 'Cheese Cake', 'date' => '2016-11-22']);
echo $object->name;
echo $object->date; // Returns A Carbon Instance

[to be continued]
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email githubissues@schulze.co instead of using the issue tracker.

## Credits

- [Felix Schulze][link-author]
- [All Contributors][link-contributors]

A great thanks to [Taylor Otwell](https://github.com/taylorotwell) for Laravel.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/schulzefelix/laravel-data-transfer-object.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/schulzefelix/laravel-data-transfer-object/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/schulzefelix/laravel-data-transfer-object.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/schulzefelix/laravel-data-transfer-object.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/schulzefelix/laravel-data-transfer-object
[link-travis]: https://travis-ci.org/schulzefelix/laravel-data-transfer-object
[link-scrutinizer]: https://scrutinizer-ci.com/g/schulzefelix/laravel-data-transfer-object/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/schulzefelix/laravel-data-transfer-object
[link-downloads]: https://packagist.org/packages/schulzefelix/laravel-data-transfer-object
[link-author]: https://github.com/schulzefelix
[link-contributors]: ../../contributors
