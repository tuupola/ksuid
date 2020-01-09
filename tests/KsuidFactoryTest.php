<?php

declare(strict_types=1);

/*

Copyright (c) 2017-2020 Mika Tuupola

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

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use DateTimeZone;

class KsuidFactoryTest extends TestCase
{
    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldCreateKsuidInstance()
    {
        $this->assertInstanceOf(Ksuid::class, KsuidFactory::create());
    }

    /* https://segment.com/blog/a-brief-history-of-the-uuid/ */
    public function testShouldCreateFromString()
    {
        $ksuid = KsuidFactory::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");
        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid);
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(1494985761, $ksuid->unixtime());
        $this->assertEquals(
            "d7b6fe8cd7cff211704d8e7b9421210b",
            bin2hex($ksuid->payload())
        );

        $datetime = (new DateTimeImmutable)
            ->setTimestamp($ksuid->unixtime())
            ->setTimeZone(new DateTimeZone("UTC"));

        $this->assertEquals(
            "2017-05-17 01:49:21",
            $datetime->format("Y-m-d H:i:s")
        );
    }

    public function testShouldCreateFromBytes()
    {
        $binary = hex2bin("05a95e21d7b6fe8cd7cff211704d8e7b9421210b");
        $ksuid = KsuidFactory::fromBytes($binary);

        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid);
        $this->assertEquals($binary, $ksuid->bytes());
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(1494985761, $ksuid->unixtime());
        $this->assertEquals(
            "d7b6fe8cd7cff211704d8e7b9421210b",
            bin2hex($ksuid->payload())
        );

        $datetime = (new DateTimeImmutable)
            ->setTimestamp($ksuid->unixtime())
            ->setTimeZone(new DateTimeZone("UTC"));

        $this->assertEquals(
            "2017-05-17 01:49:21",
            $datetime->format("Y-m-d H:i:s")
        );
    }

    public function testShouldCreateFromTimestampAndPayload()
    {
        $payload = hex2bin("d7b6fe8cd7cff211704d8e7b9421210b");
        $timestamp = 94985761;
        $ksuid = KsuidFactory::fromTimestampAndPayload($timestamp, $payload);

        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid);
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(
            "d7b6fe8cd7cff211704d8e7b9421210b",
            bin2hex($ksuid->payload())
        );
    }

    public function testShouldCreateFromTimestamp()
    {
        $ksuid = KsuidFactory::fromTimestamp(94985761);
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(1494985761, $ksuid->unixtime());
    }

    public function testShouldCreateFromUnixtime()
    {
        $ksuid = KsuidFactory::fromUnixtime(1494985761);
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(1494985761, $ksuid->unixtime());
    }

    public function testShouldHandleLeadingZeroes()
    {
        $ksuid = KsuidFactory::fromString("00000kkODHa8Ws2cSwkqjKhWDkt");
        $this->assertEquals(6, $ksuid->timestamp());
        $this->assertEquals(hex2bin("000000000000000000000000000000FF"), $ksuid->payload());
        $this->assertEquals("00000kkODHa8Ws2cSwkqjKhWDkt", (string) $ksuid);
    }

    /* https://github.com/segmentio/ksuid/blob/master/ksuid.go#L37 */
    public function testShouldHandleMaximumValue()
    {
        $binary = hex2bin("ffffffffffffffffffffffffffffffffffffffff");
        $ksuid = KsuidFactory::fromBytes($binary);

        $this->assertEquals("aWgEPTl1tmebfsQzFP4bxwgy80V", (string) $ksuid);
    }

    /* https://github.com/segmentio/ksuid/blob/master/ksuid.go#L34 */
    public function testShouldHandleMinimumValue()
    {
        $binary = hex2bin("0000000000000000000000000000000000000000");
        $ksuid = KsuidFactory::fromBytes($binary);

        $this->assertEquals("000000000000000000000000000", (string) $ksuid);
    }
}
