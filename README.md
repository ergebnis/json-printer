# json-printer

[![Build Status](https://travis-ci.org/localheinz/json-printer.svg?branch=master)](https://travis-ci.org/localheinz/json-printer)
[![codecov](https://codecov.io/gh/localheinz/json-printer/branch/master/graph/badge.svg)](https://codecov.io/gh/localheinz/json-printer)
[![Latest Stable Version](https://poser.pugx.org/localheinz/json-printer/v/stable)](https://packagist.org/packages/localheinz/json-printer)
[![Total Downloads](https://poser.pugx.org/localheinz/json-printer/downloads)](https://packagist.org/packages/localheinz/json-printer)

Provides a JSON printer, allowing for flexible indentation.

## Installation

Run

```
$ composer require localheinz/json-printer
```

## Usage

Let's assume we have a variable `$json` which contains some JSON that is not indented:

```json
{"name":"Andreas Möller","emoji":"🤓","urls":["https://localheinz.com","https://github.com/localheinz","https://twitter.com/localheinz"]}
```

or indented with 4 spaces:

```json
{
    "name":"Andreas Möller",
    "emoji":"🤓",
    "urls":[
        "https://localheinz.com",
        "https://github.com/localheinz",
        "https://twitter.com/localheinz"
    ]
}
```

but we want to indent it with 2 spaces (or tabs).

This is where `Localheinz\Json\Printer\Printer` comes in

```php
use Localheinz\Json\Printer\Printer;

$printer = new Printer();

$printed = $printer->print(
    $json, 
    '  '
);
```

which results in `$printed`:

```json
{
  "name":"Andreas Möller",
  "emoji":"🤓",
  "urls":[
    "https://localheinz.com",
    "https://github.com/localheinz",
    "https://twitter.com/localheinz"
  ]
}
```

:bulb: Note that this printer is only concerned with normalizing the 
indentation, no escaping or un-escaping occurs.

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CODE_OF_CONDUCT.md`](.github/CODE_OF_CONDUCT.md).

## License

This package is licensed using the MIT License.

## Credits

The [`Printer`](src/Printer.php) is adopted from 
[`Composer\Json\JsonFormatter`](https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php) 
(originally licensed under MIT by [Nils Adermann](https://github.com/naderman) 
and [Jordi Boggiano](https://github.com/seldaek)), who adopted it from a 
[blog post by Dave Perrett](https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/) 
(originally licensed under MIT by [Dave Perrett](https://github.com/recurser)).

The [`PrinterTest`](test/Unit/PrinterTest.php) is inspired 
by [`Composer\Test\Json\JsonFormatterTest`](https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php) 
(originally licensed under MIT by [Nils Adermann](https://github.com/naderman)
and [Jordi Boggiano](https://github.com/seldaek)), as well as 
[`ZendTest\Json\JsonTest`](https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php) 
(original licensed under New BSD License).
