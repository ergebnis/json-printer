# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

For a full diff see [`3.8.1...main`][3.8.1...main].

## [`3.8.1`][3.8.1]

For a full diff see [`3.8.0...3.8.1`][3.8.0...3.8.1].

### Fixed

- Updated branch alias ([#893]), by [@localheinz]

## [`3.8.0`][3.8.0]

For a full diff see [`3.7.0...3.8.0`][3.7.0...3.8.0].

### Changed

- Allowed installation on PHP 8.5 ([#887]), by [@localheinz]

## [`3.7.0`][3.7.0]

For a full diff see [`3.6.0...3.7.0`][3.6.0...3.7.0].

### Added

- Added support for PHP 8.4 ([#863]), by [@localheinz]

## [`3.6.0`][3.6.0]

For a full diff see [`3.5.0...3.6.0`][3.5.0...3.6.0].

### Changed

- Allowed installation on PHP 8.4 ([#841]), by [@localheinz]

## [`3.5.0`][3.5.0]

For a full diff see [`3.4.0...3.5.0`][3.4.0...3.5.0].

### Changed

- Added support for PHP 8.0 ([#752]), by [@localheinz]
- Added support for PHP 7.4 ([#753]), by [@localheinz]

## [`3.4.0`][3.4.0]

For a full diff see [`3.3.0...3.4.0`][3.3.0...3.4.0].

### Changed

- Added support for PHP 8.3 ([#682]), by [@localheinz]

### Changed

- Dropped support for PHP 8.0 ([#625]), by [@localheinz]

## [`3.3.0`][3.3.0]

For a full diff see [`3.2.0...3.3.0`][3.2.0...3.3.0].

### Changed

- Dropped support for PHP 7.4 ([#520]), by [@localheinz]

## [`3.2.0`][3.2.0]

For a full diff see [`3.1.1...3.2.0`][3.1.1...3.2.0].

### Changed

- Dropped support for PHP 7.2 ([#404]), by [@localheinz]
- Dropped support for PHP 7.3 ([#410]), by [@localheinz]

## [`3.1.1`][3.1.1]

For a full diff see [`3.1.0...3.1.1`][3.1.0...3.1.1].

### Changed

- Dropped support for PHP 7.1 ([#199]), by [@localheinz]

## [`3.1.0`][3.1.0]

For a full diff see [`3.0.2...3.1.0`][3.0.2...3.1.0].

### Added

- Added support for PHP 8.0 ([#172]), by [@localheinz]

## [`3.0.2`][3.0.2]

For a full diff see [`3.0.1...3.0.2`][3.0.1...3.0.2].

### Fixed

- Brought back support for PHP 7.1 ([#76]), by [@localheinz]

## [`3.0.1`][3.0.1]

For a full diff see [`3.0.0...3.0.1`][3.0.0...3.0.1].

### Fixed

- Removed an inappropriate `replace` configuration from `composer.json` ([#72]), by [@localheinz]

## [`3.0.0`][3.0.0]

For a full diff see [`2.0.1...3.0.0`][2.0.1...3.0.0].

### Changed

- Renamed vendor namespace `Localheinz` to `Ergebnis` after move to [@ergebnis] ([#67]), by [@localheinz]

  Run

  ```
  $ composer remove localheinz/json-printer
  ```

  and

  ```
  $ composer require ergebnis/json-printer
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Localheinz\\Json\\Printer/Ergebnis\\Json\\Printer/g' {} \;
  ```

  to replace occurrences of `Localheinz\Json\Printer` with `Ergebnis\Json\Printer`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

### Fixed

- Removed support for PHP 7.1 ([#55]), by [@localheinz]
- Required implicit dependencies `ext-json` and `ext-mbstring` explicitly ([#63]), by [@localheinz]

## [`2.0.1`][2.0.1]

For a full diff see [`2.0.0...2.0.1`][2.0.0...2.0.1].

### Fixed

- Started rejecting mixed tabs and spaces as indent ([#37]), by [@localheinz]

## [`2.0.0`][2.0.0]

For a full diff see [`1.1.0...2.0.0`][1.1.0...2.0.0].

### Changed

- Allowed specifying new-line character ([#33]), by [@localheinz]

## [`1.1.0`][1.1.0]

For a full diff see [`1.0.0...1.1.0`][1.0.0...1.1.0].

## [`1.0.0`][1.0.0]

For a full diff see [`8849fc6...1.0.0`][8849fc6...1.0.0].

[1.0.0]: https://github.com/ergebnis/json-printer/releases/tag/1.0.0
[1.1.0]: https://github.com/ergebnis/json-printer/releases/tag/1.1.0
[2.0.0]: https://github.com/ergebnis/json-printer/releases/tag/2.0.0
[2.0.1]: https://github.com/ergebnis/json-printer/releases/tag/2.0.1
[3.0.0]: https://github.com/ergebnis/json-printer/releases/tag/3.0.0
[3.0.1]: https://github.com/ergebnis/json-printer/releases/tag/3.0.1
[3.0.2]: https://github.com/ergebnis/json-printer/releases/tag/3.0.2
[3.1.0]: https://github.com/ergebnis/json-printer/releases/tag/3.1.0
[3.1.1]: https://github.com/ergebnis/json-printer/releases/tag/3.1.1
[3.2.0]: https://github.com/ergebnis/json-printer/releases/tag/3.2.0
[3.3.0]: https://github.com/ergebnis/json-printer/releases/tag/3.3.0
[3.4.0]: https://github.com/ergebnis/json-printer/releases/tag/3.4.0
[3.5.0]: https://github.com/ergebnis/json-printer/releases/tag/3.5.0
[3.6.0]: https://github.com/ergebnis/json-printer/releases/tag/3.6.0
[3.7.0]: https://github.com/ergebnis/json-printer/releases/tag/3.7.0
[3.8.0]: https://github.com/ergebnis/json-printer/releases/tag/3.8.0
[3.8.1]: https://github.com/ergebnis/json-printer/releases/tag/3.8.1

[8849fc6...1.0.0]: https://github.com/ergebnis/json-printer/compare/8849fc6...1.0.0
[1.0.0...1.1.0]: https://github.com/ergebnis/json-printer/compare/1.0.0...1.1.0
[1.1.0...2.0.0]: https://github.com/ergebnis/json-printer/compare/1.1.0...2.0.0
[2.0.0...2.0.1]: https://github.com/ergebnis/json-printer/compare/2.0.0...2.0.1
[2.0.1...3.0.0]: https://github.com/ergebnis/json-printer/compare/2.0.1...3.0.0
[3.0.0...3.0.1]: https://github.com/ergebnis/json-printer/compare/3.0.0...3.0.1
[3.0.1...3.0.2]: https://github.com/ergebnis/json-printer/compare/3.0.1...3.0.2
[3.0.2...3.1.0]: https://github.com/ergebnis/json-printer/compare/3.0.2...3.1.0
[3.1.0...3.1.1]: https://github.com/ergebnis/json-printer/compare/3.1.0...3.1.1
[3.1.1...3.2.0]: https://github.com/ergebnis/json-printer/compare/3.1.1...3.2.0
[3.2.0...3.3.0]: https://github.com/ergebnis/json-printer/compare/3.2.0...3.3.0
[3.3.0...3.4.0]: https://github.com/ergebnis/json-printer/compare/3.3.0...3.4.0
[3.4.0...3.5.0]: https://github.com/ergebnis/json-printer/compare/3.4.0...3.5.0
[3.5.0...3.6.0]: https://github.com/ergebnis/json-printer/compare/3.5.0...3.6.0
[3.6.0...3.7.0]: https://github.com/ergebnis/json-printer/compare/3.6.0...3.7.0
[3.7.0...3.8.0]: https://github.com/ergebnis/json-printer/compare/3.7.0...3.8.0
[3.8.0...3.8.1]: https://github.com/ergebnis/json-printer/compare/3.8.0...3.8.1
[3.8.1...main]: https://github.com/ergebnis/json-printer/compare/3.8.1...main

[#33]: https://github.com/ergebnis/json-printer/pull/33
[#37]: https://github.com/ergebnis/json-printer/pull/37
[#55]: https://github.com/ergebnis/json-printer/pull/55
[#63]: https://github.com/ergebnis/json-printer/pull/63
[#67]: https://github.com/ergebnis/json-printer/pull/67
[#72]: https://github.com/ergebnis/json-printer/pull/72
[#76]: https://github.com/ergebnis/json-printer/pull/77
[#172]: https://github.com/ergebnis/json-printer/pull/172
[#199]: https://github.com/ergebnis/json-printer/pull/199
[#404]: https://github.com/ergebnis/json-printer/pull/404
[#410]: https://github.com/ergebnis/json-printer/pull/410
[#520]: https://github.com/ergebnis/json-printer/pull/520
[#625]: https://github.com/ergebnis/json-printer/pull/625
[#682]: https://github.com/ergebnis/json-printer/pull/682
[#752]: https://github.com/ergebnis/json-printer/pull/752
[#753]: https://github.com/ergebnis/json-printer/pull/753
[#841]: https://github.com/ergebnis/json-printer/pull/841
[#863]: https://github.com/ergebnis/json-printer/pull/863
[#887]: https://github.com/ergebnis/json-printer/pull/887
[#893]: https://github.com/ergebnis/json-printer/pull/893

[@ergebnis]: https://github.com/ergebnis
[@localheinz]: https://github.com/localheinz
