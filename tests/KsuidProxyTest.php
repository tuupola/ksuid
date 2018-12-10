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
