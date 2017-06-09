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

class Ksuid
{
    const TIMESTAMP_SIZE = 4;
    const PAYLOAD_SIZE = 16;
    const ENCODED_SIZE = 27;
    const EPOCH = 1400000000;

    private $timestamp;
    private $payload;

    public function __construct($payload = null, $timestamp = null)
    {
        $this->payload = $payload;
        $this->timestamp = $timestamp;

        if (empty($payload)) {
            $this->payload = random_bytes(self::PAYLOAD_SIZE);
        }
        if (empty($timestamp)) {
            $this->timestamp = time() - self::EPOCH;
        }
    }

    public static function generate()
    {
        return new self;
    }

    public static function fromString($string)
    {
        $decoded = (new Base62)->decode($string);
        return self::fromBytes($decoded);
    }

    public static function fromBytes($bytes)
    {
        $timestamp = substr($bytes, 0, self::TIMESTAMP_SIZE);
        $timestamp = unpack("Nuint", $timestamp);
        $payload = substr($bytes, self::TIMESTAMP_SIZE, self::PAYLOAD_SIZE);
        return new self($payload, $timestamp["uint"]);
    }

    public function bytes()
    {
        return pack("N", $this->timestamp) . $this->payload;
    }

    public function string()
    {
        $encoded = (new Base62)->encode($this->bytes());
        if ($padding = self::ENCODED_SIZE - strlen($encoded)) {
            $encoded = str_repeat("0", $padding) . $encoded;
        }
        return $encoded;
    }

    public function payload()
    {
        return $this->payload;
    }

    public function timestamp()
    {
        return $this->timestamp;
    }

    public function unixtime()
    {
        return $this->timestamp + self::EPOCH;
    }

    public function __toString()
    {
        return $this->string();
    }
}
