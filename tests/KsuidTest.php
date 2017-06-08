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

namespace Tuupola\Ksuid;

use PHPUnit\Framework\TestCase;
use Tuupola\Ksuid;
use Tuupola\Base62;
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

    /* https://segment.com/blog/a-brief-history-of-the-uuid/ */
    public function testShouldCreateFromString()
    {
        $ksuid = Ksuid::fromString("0o5Fs0EELR0fUjHjbCnEtdUwQe3");
        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid);
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(
            "d7b6fe8cd7cff211704d8e7b9421210b",
            bin2hex($ksuid->payload())
        );
        $datetime = $ksuid->datetime();
        $datetime->setTimeZone(new DateTimeZone("UTC"));
        $this->assertEquals(
            "2017-05-17 01:49:21",
            $datetime->format("Y-m-d H:i:s")
        );
    }

    public function testShouldCreateFromBytes()
    {
        $binary = (new Base62)->decode("0o5Fs0EELR0fUjHjbCnEtdUwQe3");
        $ksuid = Ksuid::fromBytes($binary);
        $this->assertEquals("0o5Fs0EELR0fUjHjbCnEtdUwQe3", (string) $ksuid);
        $this->assertEquals($binary, $ksuid->bytes());
        $this->assertEquals(94985761, $ksuid->timestamp());
        $this->assertEquals(
            "d7b6fe8cd7cff211704d8e7b9421210b",
            bin2hex($ksuid->payload())
        );
        $datetime = $ksuid->datetime();
        $datetime->setTimeZone(new DateTimeZone("UTC"));
        $this->assertEquals(
            "2017-05-17 01:49:21",
            $datetime->format("Y-m-d H:i:s")
        );
    }
}
