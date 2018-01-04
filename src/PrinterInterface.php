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
    public function print(string $original, bool $unEscapeUnicode, bool $unEscapeSlashes): string;
}
