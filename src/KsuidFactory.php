<?php

/*

Copyright (c) 2017-2019 Mika Tuupola

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

/**
 * @see       https://github.com/tuupola/ksuid
 * @license   https://www.opensource.org/licenses/mit-license.php
 */

namespace Tuupola;

class KsuidFactory
{
    public static function create(): Ksuid
    {
        return new Ksuid;
    }

    public static function fromTimestamp(int $timestamp): Ksuid
    {
        return new Ksuid($timestamp);
    }

    public static function fromUnixtime(int $unixtime): Ksuid
    {
        $timestamp = $unixtime - Ksuid::EPOCH;
        return new Ksuid($timestamp);
    }

    public static function fromTimestampAndPayload(int $timestamp, string $payload): Ksuid
    {
        return new Ksuid($timestamp, $payload);
    }

    public static function fromString(string $string): Ksuid
    {
        $decoded = (new Base62)->decode($string);
        return self::fromBytes($decoded);
    }

    public static function fromBytes(string $bytes): Ksuid
    {
        $bytes = ltrim($bytes, "\0x00");
        $timestamp = substr($bytes, 0, Ksuid::TIMESTAMP_SIZE);
        $timestamp = unpack("Nuint", $timestamp);
        $payload = substr($bytes, Ksuid::TIMESTAMP_SIZE, Ksuid::PAYLOAD_SIZE);
        return new Ksuid($timestamp["uint"], $payload);
    }
}
