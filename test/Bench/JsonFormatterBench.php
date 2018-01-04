<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/json-printer
 */

namespace Localheinz\Json\Printer\Test\Bench;

use Localheinz\Json\Printer\JsonFormatter;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

final class JsonFormatterBench
{
    /**
     * @see https://www.json-generator.com/
     *
     * @var string
     */
    private $filename = __DIR__ . '/../Fixture/example.json';

    /**
     * @Revs(5)
     */
    public function benchJsonEncode()
    {
        $original = \file_get_contents($this->filename);

        \json_encode(\json_decode($original));
    }

    /**
     * @Revs(5)
     */
    public function benchFormat()
    {
        $this->print(
            false,
            false
        );
    }

    /**
     * @Revs(5)
     */
    public function benchFormatWithUnescapeUnicode()
    {
        $this->print(
            true,
            false
        );
    }

    /**
     * @Revs(5)
     */
    public function benchFormatWithUnescapeSlashes()
    {
        $this->print(
            false,
            true
        );
    }

    /**
     * @Revs(5)
     */
    public function benchFormatWithUnescapeUnicodeAndUnescapeSlashes()
    {
        $this->print(
            true,
            true
        );
    }

    private function print(bool $unescapeUnicode, bool $unescapeSlashes)
    {
        $json = \file_get_contents($this->filename);

        JsonFormatter::format(
            $json,
            $unescapeUnicode,
            $unescapeSlashes
        );
    }
}
