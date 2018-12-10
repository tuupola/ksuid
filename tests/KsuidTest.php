<?php

/*
 * This file is part of the KSUID package
 *
 * Copyright (c) 2017 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/ksuid
 *
 */

namespace Tuupola;

use PHPUnit\Framework\TestCase;
use Tuupola\Ksuid;
use Tuupola\Base62;
use DateTimeImmutable;
use DateTimeZone;

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
}
