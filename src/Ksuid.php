<?php

declare(strict_types=1);

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

use InvalidArgumentException;

class Ksuid
{
    const TIMESTAMP_SIZE = 4;
    const PAYLOAD_SIZE = 16;
    const ENCODED_SIZE = 27;
    const EPOCH = 1400000000;

    private $timestamp;
    private $payload;

    public function __construct(int $timestamp = null, string $payload = null)
    {
        if ($payload && self::PAYLOAD_SIZE !== strlen($payload)) {
            throw new InvalidArgumentException(
                sprintf("Payload must be exactly %d bytes", self::PAYLOAD_SIZE)
            );
        }

        $this->payload = $payload;
        $this->timestamp = $timestamp;

        if (null === $payload) {
            $this->payload = random_bytes(self::PAYLOAD_SIZE);
        }
        if (null === $timestamp) {
            $this->timestamp = time() - self::EPOCH;
        }
    }

    public function bytes(): string
    {
        return pack("N", $this->timestamp) . $this->payload;
    }

    public function string(): string
    {
        $encoded = (new Base62)->encode($this->bytes());
        if ($padding = self::ENCODED_SIZE - strlen($encoded)) {
            $encoded = str_repeat("0", $padding) . $encoded;
        }
        return $encoded;
    }

    public function payload(): string
    {
        return (string) $this->payload;
    }

    public function timestamp(): int
    {
        return (int) $this->timestamp;
    }

    public function unixtime(): int
    {
        return $this->timestamp + self::EPOCH;
    }

    public function __toString(): string
    {
        return $this->string();
    }
}
