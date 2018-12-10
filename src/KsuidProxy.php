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

class KsuidProxy
{
    public static function generate($payload = null, $timestamp = null): Ksuid
    {
        return new Ksuid($payload, $timestamp);
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
        return new Ksuid($payload, $timestamp["uint"]);
    }
}
