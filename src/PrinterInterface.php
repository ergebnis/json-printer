<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018-2020 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-printer
 */

namespace Ergebnis\Json\Printer;

interface PrinterInterface
{
    /**
     * @param string $json
     * @param string $indent
     * @param string $newLine
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function print(string $json, string $indent = '    ', string $newLine = \PHP_EOL): string;
}
