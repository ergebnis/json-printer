<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/localheinz/json-printer
 */

namespace Localheinz\Json\Printer\Test\AutoReview;

use Localheinz\Test\Util\Helper;
use PHPUnit\Framework;

/**
 * @internal
 * @coversNothing
 */
final class SrcCodeTest extends Framework\TestCase
{
    use Helper;

    public function testProductionClassesAreAbstractOrFinal(): void
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__ . '/../../src');
    }

    public function testProductionClassesHaveTests(): void
    {
        $this->assertClassesHaveTests(
            __DIR__ . '/../../src',
            'Localheinz\\Json\\Printer\\',
            'Localheinz\\Json\\Printer\\Test\\Unit\\'
        );
    }
}
