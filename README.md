# json-printer

[![Integrate](https://github.com/ergebnis/json-printer/workflows/Integrate/badge.svg)](https://github.com/ergebnis/json-printer/actions)
[![Merge](https://github.com/ergebnis/json-printer/workflows/Merge/badge.svg)](https://github.com/ergebnis/json-printer/actions)
[![Release](https://github.com/ergebnis/json-printer/workflows/Release/badge.svg)](https://github.com/ergebnis/json-printer/actions)
[![Renew](https://github.com/ergebnis/json-printer/workflows/Renew/badge.svg)](https://github.com/ergebnis/json-printer/actions)

[![Code Coverage](https://codecov.io/gh/ergebnis/json-printer/branch/main/graph/badge.svg)](https://codecov.io/gh/ergebnis/json-printer)

[![Latest Stable Version](https://poser.pugx.org/ergebnis/json-printer/v/stable)](https://packagist.org/packages/ergebnis/json-printer)
[![Total Downloads](https://poser.pugx.org/ergebnis/json-printer/downloads)](https://packagist.org/packages/ergebnis/json-printer)
[![Monthly Downloads](http://poser.pugx.org/ergebnis/json-printer/d/monthly)](https://packagist.org/packages/ergebnis/json-printer)

This project provides a [`composer`](https://getcomposer.org) package with a JSON printer, allowing for flexible indentation.

## Installation

Run

```sh
composer require ergebnis/json-printer
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

This is where `Ergebnis\Json\Printer\Printer` comes in

```php
<?php

declare(strict_types=1);

use Ergebnis\Json\Printer;

$printer = new Printer\Printer();

$printed = $printer->print(
    $json,
    '  ',
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

:bulb: Note that this printer is only concerned with normalizing the indentation, no escaping or un-escaping occurs.

## Changelog

The maintainers of this project record notable changes to this project in a [changelog](CHANGELOG.md).

## Contributing

The maintainers of this project suggest following the [contribution guide](.github/CONTRIBUTING.md).

## Code of Conduct

The maintainers of this project ask contributors to follow the [code of conduct](https://github.com/ergebnis/.github/blob/main/CODE_OF_CONDUCT.md).

## General Support Policy

The maintainers of this project provide limited support.

You can support the maintenance of this project by [sponsoring @ergebnis](https://github.com/sponsors/ergebnis).

## PHP Version Support Policy

This project supports PHP versions with [active and security support](https://www.php.net/supported-versions.php).

The maintainers of this project add support for a PHP version following its initial release and drop support for a PHP version when it has reached the end of security support.

## Security Policy

This project has a [security policy](.github/SECURITY.md).

## License

This project uses the [MIT license](LICENSE.md).

## Credits

The [`Printer`](src/Printer.php) is adopted from [`Composer\Json\JsonFormatter`](https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php) (originally licensed under MIT by [Nils Adermann](https://github.com/naderman) and [Jordi Boggiano](https://github.com/seldaek)), who adopted it from a [blog post by Dave Perrett](https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/) (originally licensed under MIT by [Dave Perrett](https://github.com/recurser)).

The [`PrinterTest`](test/Unit/PrinterTest.php) is inspired by [`Composer\Test\Json\JsonFormatterTest`](https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php) (originally licensed under MIT by [Nils Adermann](https://github.com/naderman) and [Jordi Boggiano](https://github.com/seldaek)), as well as [`ZendTest\Json\JsonTest`](https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php) (originally licensed under New BSD License).

## Social

Follow [@localheinz](https://twitter.com/intent/follow?screen_name=localheinz) and [@ergebnis](https://twitter.com/intent/follow?screen_name=ergebnis) on Twitter.
