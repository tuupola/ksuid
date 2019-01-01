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
use Tuupola\Ksuid;
use InvalidArgumentException;

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

    public function testShouldThrowWithInvalidTimestamp()
    {
        $this->expectException(InvalidArgumentException::class);
        new Ksuid("foo");
    }
}
