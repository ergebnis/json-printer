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

namespace Localheinz\Json\Printer\Test\Unit;

use Localheinz\Json\Printer\JsonFormatter;
use PHPUnit\Framework;

final class JsonFormatterTest extends Framework\TestCase
{
    /**
     * @see https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php#L20-L34
     */
    public function testUnicodeWithPrependedSlash()
    {
        if (!\extension_loaded('mbstring')) {
            $this->markTestSkipped('Test requires the mbstring extension');
        }

        $data = '"' . \chr(92) . \chr(92) . \chr(92) . 'u0119"';
        $encodedData = JsonFormatter::format($data, true, true);
        $expected = '34+92+92+196+153+34';
        $this->assertEquals($expected, $this->getCharacterCodes($encodedData));
    }

    /**
     * @see https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php#L36-L49
     *
     * @param string $string
     *
     * @return string
     */
    protected function getCharacterCodes($string)
    {
        $codes = [];

        for ($i = 0; $i < \strlen($string); ++$i) {
            $codes[] = \ord($string[$i]);
        }

        return \implode('+', $codes);
    }
}
