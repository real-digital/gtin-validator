# Real GTIN Validator [![Build Status](https://travis-ci.org/hitmeister/gtin-validator.svg?branch=master)](https://travis-ci.org/hitmeister/gtin-validator)

[![Latest Stable Version](https://img.shields.io/packagist/v/real-digital/gtin-validator.svg)](https://packagist.org/packages/real-digital/gtin-validator)
[![Coverage Status](https://coveralls.io/repos/github/real-digital/gtin-validator/badge.svg?branch=master)](https://coveralls.io/github/real-digital/gtin-validator?branch=master)

A GTIN is a string of digits that uniquely identifies a trade item (a product that is bought and sold). 
A GTIN is globally unique, meaning that no two products in the world share the same GTIN.

This library provides a straightforward way by which a number can be determined to be a valid GTIN
or suspected of being invalid in some way.

## Installation

via Composer

``` bash
$ composer require real-digital/gtin-validator
```

via GitHub

``` bash
$ git clone https://github.com/real-digital/gtin-validator.git
```

### Usage

```php
<?php

use Real\Validator\Gtin;

// create a valid GTIN
$value = '4006381333931';
$gtin = Gtin\Factory::create($value);


// handle errors
$value = 'any invalid value';
try {
    $gtin = Gtin\Factory::create($value);
} catch (Gtin\NonNormalizable $e) {
    // ...
}

```

### GTIN interface overview

Each created GTIN implements a common interface. This is a complete list of its methods:

| Method         | Type    | Functionality                                                      |
|----------------|---------|--------------------------------------------------------------------|
| `checkDigit()` | integer | Retrieve the rightmost digit called the "Check Digit"              |
| `indicator()`  | integer | Retrieve the "Indicator" component                                 |
| `key()`        | string  | Retrieve GTIN value having a length corresponding to its variation |
| `length()`     | integer | Retrieve length of the variation                                   |
| `origin()`     | string  | Retrieve an origin value used for GTIN creation                    |
| `padded()`     | string  | Retrieve key padded to 14 digits                                   |
| `prefix()`     | string  | Retrieve GS1 Prefix                                                |
| `variation()`  | string  | Retrieve variation name                                            |


## Testing

``` bash
$ composer test
```

## License

Real GTIN Validator is licensed under The Apache License 2.0. Please see [LICENSE](LICENSE) for details.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information.
