# Data Transfer Objects with Attribute Casting and Date Mutators

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

- [Introduction](#introduction)
- [Accessors & Mutators](#accessors-and-mutators)
    - [Defining An Accessor](#defining-an-accessor)
    - [Defining A Mutator](#defining-a-mutator)
- [Date Mutators](#date-mutators)
- [Attribute Casting](#attribute-casting)
- [Serializing Objects & Collections](#serializing-objects-and-collections)
    - [Serializing To Arrays](#serializing-to-arrays)
    - [Serializing To JSON](#serializing-to-json)

<a name="introduction"></a>
## Introduction

Accessors and mutators allow you to format attribute values when you retrieve or set them on object instances.

In addition to custom accessors and mutators, it can also automatically cast date fields to [Carbon](https://github.com/briannesbitt/Carbon) instances.

<a name="accessors-and-mutators"></a>
## Accessors & Mutators

<a name="defining-an-accessor"></a>
### Defining An Accessor

To define an accessor, create a `getFooAttribute` method on your object where `Foo` is the "studly" cased name of the column you wish to access. In this example, we'll define an accessor for the `first_name` attribute. The accessor will automatically be called when attempting to retrieve the value of the `slug` attribute:

    <?php

    namespace App;

    use SchulzeFelix\DataTransferObject\DataTransferObject;

    class Project extends DataTransferObject
    {
        /**
         * Get the objects URL friendly slug.
         *
         * @return string
         */
        public function getSlugAttribute()
        {
            return str_slug($value);
        }
    }


<a name="defining-a-mutator"></a>
### Defining A Mutator

To define a mutator, define a `setFooAttribute` method on your object where `Foo` is the "studly" cased name of the column you wish to access.

    <?php

    namespace App;

    use SchulzeFelix\DataTransferObject\DataTransferObject;

    class Project extends DataTransferObject
    {
        /**
         * Set the objects's title.
         *
         * @param  string  $value
         * @return void
         */
        public function serTitleAttribute($value)
        {
            $this->attributes['title'] = title_case($value);
        }
    }

<a name="date-mutators"></a>
## Date Mutators

By default, it will convert the `created_at` and `updated_at` columns to instances of [Carbon](https://github.com/briannesbitt/Carbon), which extends the PHP `DateTime` class to provide an assortment of helpful methods. You may customize which dates are automatically mutated:

    <?php

    namespace App;

    use SchulzeFelix\DataTransferObject\DataTransferObject;

    class Project extends DataTransferObject
    {
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = [
            'date',
            'deleted_at'
        ];
    }


As noted above, when retrieving attributes that are listed in your `$dates` property, they will automatically be cast to [Carbon](https://github.com/briannesbitt/Carbon) instances, allowing you to use any of Carbon's methods on your attributes:

    return $project->deleted_at->getTimestamp();


<a name="attribute-casting"></a>
## Attribute Casting

The `$casts` property on your object provides a convenient method of converting attributes to common data types. The `$casts` property should be an array where the key is the name of the attribute being cast and the value is the type you wish to cast the attribute to. The supported cast types are: `integer`, `real`, `float`, `double`, `string`, `boolean`, `object`, `array`, `collection`, `date`, `datetime`, and `timestamp`.

For example, let's cast the `is_index` attribute, which was assigned as string to a boolean value:

    <?php

    namespace App;

    use SchulzeFelix\DataTransferObject\DataTransferObject;

    class Project extends DataTransferObject
    {
        /**
         * The attributes that should be casted to native types.
         *
         * @var array
         */
        protected $casts = [
            'is_index' => 'boolean',
        ];
    }

Now the `is_index` attribute will always be cast to a boolean when you access it, even if the underlying value was set as integer or string:

    if ($project->is_index) {
        //
    }

<a name="serializing-objects-and-collections"></a>
## Serializing Objects & Collections

<a name="serializing-to-arrays"></a>
### Serializing To Arrays

To convert a object and its nested objects and collections to an array, you should use the `toArray` method. This method is recursive, so all attributes will be converted to arrays:

    return $project->toArray();

<a name="serializing-to-json"></a>
### Serializing To JSON

To convert a object to JSON, you should use the `toJson` method. Like `toArray`, the `toJson` method is recursive, so all attributes and nested objects will be converted to JSON:

    return $project->toJson();

Alternatively, you may cast a object or collection to a string, which will automatically call the `toJson` method on the object or collection:

    return (string) $project;

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

A great thanks to [Taylor Otwell](https://github.com/taylorotwell) and all contributors for Laravel.

Modified source comes from the [Eloquent Model](https://github.com/laravel/framework/blob/5.3/src/Illuminate/Database/Eloquent/Model.php).

Docs modified from [Laravel Docs](https://github.com/laravel/docs).

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
