<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-printer
 */

namespace Ergebnis\Json\Printer\Test\Bench;

use Ergebnis\Json\Printer\Printer;
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
    public function benchJsonEncode(): void
    {
        $original = \file_get_contents($this->filename);

        if (!\is_string($original)) {
            throw new \RuntimeException(\sprintf(
                'Failed getting contents of file "%s".',
                $this->filename
            ));
        }

        \json_encode(\json_decode($original));
    }

    /**
     * @Revs(5)
     */
    public function benchPrint(): void
    {
        $json = \file_get_contents($this->filename);

        if (!\is_string($json)) {
            throw new \RuntimeException(\sprintf(
                'Failed getting contents of file "%s".',
                $this->filename
            ));
        }

        $printer = new Printer();

        $printer->print($json);
    }
}
