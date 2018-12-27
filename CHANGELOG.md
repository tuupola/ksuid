# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## [0.2.0](https://github.com/tuupola/ksuid/compare/0.1.4...0.2.0) - unreleased
### Changed
- Switched order of timestamp and payload parameters everywhere
- Moved static functions to a factory
  ```php
  use Tuupola\KsuidFactory as Ksuid;

  $ksuid = KsuidFactory::create();

  $ksuid = KsuidFactory::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");

  $binary = hex2bin("05a95e21d7b6fe8cd7cff211704d8e7b9421210b");
  $ksuid = KsuidFactory::fromBytes($binary);
  ```

### Added
- Additional factory methods
  ```php
  use Tuupola\KsuidFactory as Ksuid;

  $ksuid = KsuidFactory::fromTimestamp(94985761);

  $ksuid = KsuidFactory::fromUnixtime(1494985761);

  $timestamp = 94985761;
  $payload = hex2bin("d7b6fe8cd7cff211704d8e7b9421210b");
  $ksuid = KsuidFactory::fromParts($timestamp, $payload);
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

0.1.0 - 2017-06-09

Initial release.