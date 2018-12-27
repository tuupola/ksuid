# KSUID

This library implements the [K-Sortable Globally Unique IDs](https://github.com/segmentio/ksuid) from Segment. See also the article called [A Brief History of the UUID](https://segment.com/blog/a-brief-history-of-the-uuid/).

> KSUID is for K-Sortable Unique IDentifier. It's a way to generate globally unique IDs similar to RFC 4122 UUIDs, but contain a time component so they can be "roughly" sorted by time of creation. The remainder of the KSUID is randomly generated bytes.

[![Latest Version](https://img.shields.io/packagist/v/tuupola/ksuid.svg?style=flat-square)](https://packagist.org/packages/tuupola/ksuid)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/tuupola/ksuid/master.svg?style=flat-square)](https://travis-ci.org/tuupola/ksuid)
[![Coverage](https://img.shields.io/codecov/c/github/tuupola/ksuid.svg?style=flat-square)](https://codecov.io/github/tuupola/ksuid)

## Install

Install with [composer](https://getcomposer.org/).

``` bash
$ composer require tuupola/ksuid
```

## Usage

Included Base62 implementation has both PHP and [GMP](http://php.net/manual/en/ref.gmp.php) based encoders. By default encoder and decoder will use GMP functions if the extension is installed. If GMP is not available pure PHP encoder will be used instead.

Note! Throughout the code the term `timestamp` refers to KSUID timestamp. The term `unixtime` refers to the traditional Unix time. KSUID timestamp and Unix time have different Epoch.

```php
use Tuupola\Ksuid;

$ksuid = new Ksuid;

print $ksuid; /* p6UEyCc8D8ecLijAI5zVwOTP3D0 */

print $ksuid->timestamp(); /* 94985761 */
print $ksuid->unixtime(); /* 1494985761 */
print bin2hex($ksuid->payload()); /* d7b6fe8cd7cff211704d8e7b9421210b */

$datetime = (new \DateTimeImmutable)
    ->setTimestamp($ksuid->unixtime())
    ->setTimeZone(new \DateTimeZone("UTC"));

print $datetime->format("Y-m-d H:i:s"); /* 2017-05-17 01:49:21 */
```

If you prefer static syntax you can use one of the provided factories.

```php
use Tuupola\KsuidFactory as Ksuid;

$ksuid = Ksuid::create();

$ksuid = Ksuid::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");

$binary = hex2bin("05a95e21d7b6fe8cd7cff211704d8e7b9421210b");
$ksuid = Ksuid::fromBytes($binary);

$ksuid = KsuidFactory::fromTimestamp(94985761);

$ksuid = KsuidFactory::fromUnixtime(1494985761);

$timestamp = 94985761;
$payload = hex2bin("d7b6fe8cd7cff211704d8e7b9421210b");
$ksuid = KsuidFactory::fromParts($timestamp, $payload);
```

## Testing

You can run tests either manually or automatically on every code change. Automatic tests require [entr](http://entrproject.org/) to work.

``` bash
$ composer test
```
``` bash
$ brew install entr
$ composer watch
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email tuupola@appelsiini.net instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
