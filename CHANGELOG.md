# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

For a full diff see [`2.0.1...master`][2.0.1...master].

### Changed

* Renamed vendor namespace `Localheinz` to `Ergebnis` after move to [@ergebnis] ([#67]), by [@localheinz]

### Fixed

* Removed support for PHP 7.1 ([#55]), by [@localheinz]
* Required implicit dependencies `ext-json` and `ext-mbstring` explicitly ([#63]), by [@localheinz]

[2.0.1...master]: https://github.com/ergebnis/json-printer/compare/2.0.1...master

[#55]: https://github.com/ergebnis/json-printer/pull/55
[#63]: https://github.com/ergebnis/json-printer/pull/63
[#67]: https://github.com/ergebnis/json-printer/pull/67

[@ergebnis]: https://github.com/ergebnis
[@localheinz]: https://github.com/localheinz
