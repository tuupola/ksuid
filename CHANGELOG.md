# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## [2.1.0](https://github.com/tuupola/ksuid/compare/2.0.0...2.1.0) - 2020-09-10
### Added
- Allow installing with PHP 8 ([#8](https://github.com/tuupola/ksuid/pull/8)).

## [2.0.0](https://github.com/tuupola/ksuid/compare/1.0.1...2.0.0) - 2019-01-06

This is same previous release but targets modern PHP versions.

### Changed
- PHP 7.1 is now minimum requirement
- All methods have return types
- All methods are typehinted
- All type juggling is removed

## [1.0.1](https://github.com/tuupola/ksuid/compare/1.0.0...1.0.1) - 2019-01-06
### Fixed
- Parsing a KSUID whose timestamp is far away in history failed in some cases. This happened when the base62 string has been zero padded to 27 characters. Padding causes the internal byte representation to change.

## [1.0.0](https://github.com/tuupola/ksuid/compare/0.3.0...1.0.0) - 2019-01-05

This is same previous release but released as stable.

## [0.3.0](https://github.com/tuupola/ksuid/compare/0.2.0...0.3.0) - 2019-01-01
### Changed
- Renamed `KsuidFactory::fromParts()` to `KsuidFactory::fromTimestampAndPayload()`

### Added
- Basic validation for input parameters

## [0.2.0](https://github.com/tuupola/ksuid/compare/0.1.4...0.2.0) - 2018-12-27
### Changed
- Switched order of timestamp and payload parameters everywhere
- Moved static functions to a factory
  ```php
  use Tuupola\KsuidFactory as Ksuid;

  $ksuid = Ksuid::create();

  $ksuid = Ksuid::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");

  $binary = hex2bin("05a95e21d7b6fe8cd7cff211704d8e7b9421210b");
  $ksuid = Ksuid::fromBytes($binary);
  ```

### Added
- Additional factory methods
  ```php
  use Tuupola\KsuidFactory as Ksuid;

  $ksuid = Ksuid::fromTimestamp(94985761);

  $ksuid = Ksuid::fromUnixtime(1494985761);

  $timestamp = 94985761;
  $payload = hex2bin("d7b6fe8cd7cff211704d8e7b9421210b");
  $ksuid = Ksuid::fromParts($timestamp, $payload);
  ```

## [0.1.4](https://github.com/tuupola/ksuid/compare/0.1.3...0.1.4) - 2018-12-09
### Fixed
- Allow using tuupola/base62:^1.0

## [0.1.3](https://github.com/tuupola/ksuid/compare/0.1.2...0.1.3) - 2018-10-29
### Fixed
- Allow using tuupola/base62:^0.11.0

## [0.1.2](https://github.com/tuupola/ksuid/compare/0.1.1...0.1.2) - 2018-04-07
### Fixed
- Allow using tuupola/base62:^0.10.0

## [0.1.1](https://github.com/tuupola/ksuid/compare/0.1.0...0.1.1) - 2017-12-11
### Fixed
- Allow using tuupola/base62:^0.9.0

## 0.1.0 - 2017-06-09

Initial release.