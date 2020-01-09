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
use Tuupola\Ksuid;
use InvalidArgumentException;
use TypeError;

class KsuidTest extends TestCase
{
    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldConstruct()
    {
        $ksuid = new Ksuid;
        $this->assertInstanceOf(Ksuid::class, $ksuid);
    }

    public function testShouldBe20Bytes()
    {
        $ksuid = new Ksuid;
        $this->assertEquals(20, strlen($ksuid->bytes()));
    }

    public function testShouldBe27Characters()
    {
        $ksuid = new Ksuid;
        $this->assertEquals(27, strlen((string)$ksuid));
    }

    public function testShouldThrowWithInvalidPayload()
    {
        $this->expectException(InvalidArgumentException::class);

        $payload = hex2bin("d7b6fe80");
        new Ksuid(null, $payload);
    }

    public function testShouldThrowWithNonStringPayload()
    {
        $this->expectException(TypeError::class);

        $payload = 123456;
        new Ksuid(null, $payload);
    }

    public function testShouldThrowWithInvalidTimestamp()
    {
        $this->expectException(TypeError::class);
        new Ksuid("foo");
    }

    /* https://github.com/segmentio/ksuid/blob/master/README.md */
    public function testShouldMatchValuesFromReadme()
    {
        $ksuid1 = new Ksuid(107611700, hex2bin("9850EEEC191BF4FF26F99315CE43B0C8"));
        $ksuid2 = new Ksuid(107611700, hex2bin("CC55072555316F45B8CA2D2979D3ED0A"));
        $ksuid3 = new Ksuid(107611700, hex2bin("BA1C205D6177F0992D15EE606AE32238"));
        $ksuid4 = new Ksuid(107611700, hex2bin("67517BA309EA62AE7991B27BB6F2FCAC"));
        $ksuid5 = new Ksuid(107610780, hex2bin("73FC1AA3B2446246D6E89FCD909E8FE8"));

        $this->assertEquals("0uk1Hbc9dQ9pxyTqJ93IUrfhdGq", (string) $ksuid1);
        $this->assertEquals("0uk1HdCJ6hUZKDgcxhpJwUl5ZEI", (string) $ksuid2);
        $this->assertEquals("0uk1HcdvF0p8C20KtTfdRSB9XIm", (string) $ksuid3);
        $this->assertEquals("0uk1Ha7hGJ1Q9Xbnkt0yZgNwg3g", (string) $ksuid4);
        $this->assertEquals("0ujzPyRiIAffKhBux4PvQdDqMHY", (string) $ksuid5);
    }

    /* https://segment.com/blog/a-brief-history-of-the-uuid/ */
    public function testShouldMatchValuesFromBlog()
    {
        $ksuid1 = new Ksuid(94985761, hex2bin("D7B6FE8CD7CFF211704D8E7B9421210B"));

        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid1);
    }

    public function testShouldHandleLeadingZeroes()
    {
        $ksuid = new Ksuid(6, hex2bin("000000000000000000000000000000FF"));

        $this->assertEquals("00000kkODHa8Ws2cSwkqjKhWDkt", (string) $ksuid);
        $this->assertEquals(27, strlen((string)$ksuid));
    }
}
