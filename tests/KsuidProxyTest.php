<?php

/*

Copyright (c) 2017-2018 Mika Tuupola

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

class KsuidProxyTest extends TestCase
{
    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testGenerateShouldReturnKsuidInstance()
    {
        $this->assertInstanceOf(Ksuid::class, KsuidProxy::generate());
    }

    /* https://segment.com/blog/a-brief-history-of-the-uuid/ */
    public function testShouldCreateFromString()
    {
        $ksuid = KsuidProxy::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");
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
        $ksuid = KsuidProxy::fromBytes($binary);

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
}
