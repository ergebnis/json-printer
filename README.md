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

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CODE_OF_CONDUCT.md`](.github/CODE_OF_CONDUCT.md).

## License

This package is licensed using the MIT License.

## Credits

The [`JsonFormatter`](src/JsonFormatter.php) is adopted from 
[`Composer\Json\JsonFormatter`](https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php) 
(originally licensed under MIT by [Nils Adermann](https://github.com/naderman) 
and [Jordi Boggiano](https://github.com/seldaek), who adopted it from a 
[blog post by Dave Perrett](https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/) 
(originally licensed under MIT by [Dave Perrett](https://github.com/recurser)).

The [`JsonFormatterTest`](test/Unit/JsonFormatterTest.php) is inspired 
by [`Composer\Test\Json\JsonFormatterTest`](https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php) 
(originally licensed under MIT by [Nils Adermann](https://github.com/naderman)
and [Jordi Boggiano](https://github.com/seldaek), as well as 
[`ZendTest\Json\JsonTest`](https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php) 
(original licensed under New BSD License).
