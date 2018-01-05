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

use Localheinz\Json\Printer\Printer;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

final class PrinterBench
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
    public function benchPrint()
    {
        $json = \file_get_contents($this->filename);

        $printer = new Printer();

        $printer->print($json);
    }
}
