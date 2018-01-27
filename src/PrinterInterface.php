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

namespace Localheinz\Json\Printer;

interface PrinterInterface
{
    /**
     * @param string $json
     * @param string $indent
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function print(string $json, string $indent = '    '): string;
}
