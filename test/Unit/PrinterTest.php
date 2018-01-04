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

use Localheinz\Json\Printer\Printer;
use Localheinz\Json\Printer\PrinterInterface;
use Localheinz\Test\Util\Helper;
use PHPUnit\Framework;

final class PrinterTest extends Framework\TestCase
{
    use Helper;

    public function testImplementsPrinterInterface()
    {
        $this->assertClassImplementsInterface(PrinterInterface::class, Printer::class);
    }

    /**
     * @see https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php#L20-L34
     */
    public function testUnicodeWithPrependedSlash()
    {
        if (!\extension_loaded('mbstring')) {
            $this->markTestSkipped('Test requires the mbstring extension');
        }

        $original = '"' . \chr(92) . \chr(92) . \chr(92) . 'u0119"';

        $expected = '34+92+92+196+153+34';

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $this->getCharacterCodes($printed));
    }

    public function testPrintPrintsArrayPretty()
    {
        $original = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas M\u00f6ller",
    "🤓",
    "https:\/\/localheinz.com"
]
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            false,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsArrayPrettyWithUnEscapeUnicode()
    {
        $original = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas Möller",
    "🤓",
    "https:\/\/localheinz.com"
]
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsArrayPrettyWithUnEscapeSlashes()
    {
        $original = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas M\u00f6ller",
    "🤓",
    "https://localheinz.com"
]
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            false,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsArrayPrettyWithUnEscapeUnicodeAndUnEscapeSlashes()
    {
        $original = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas Möller",
    "🤓",
    "https://localheinz.com"
]
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsObjectPretty()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $expected = <<<'JSON'
{
    "name": "Andreas M\u00f6ller",
    "emoji": "🤓",
    "urls": [
        "https:\/\/localheinz.com",
        "https:\/\/github.com\/localheinz",
        "https:\/\/twitter.com\/localheinz"
    ]
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            false,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsObjectPrettyWithUnEscapeUnicode()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $expected = <<<'JSON'
{
    "name": "Andreas Möller",
    "emoji": "🤓",
    "urls": [
        "https:\/\/localheinz.com",
        "https:\/\/github.com\/localheinz",
        "https:\/\/twitter.com\/localheinz"
    ]
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsObjectPrettyWithUnEscapeSlashes()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $expected = <<<'JSON'
{
    "name": "Andreas M\u00f6ller",
    "emoji": "🤓",
    "urls": [
        "https://localheinz.com",
        "https://github.com/localheinz",
        "https://twitter.com/localheinz"
    ]
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            false,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsObjectPrettyWithUnEscapeUnicodeAndUnEscapeSlashes()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $expected = <<<'JSON'
{
    "name": "Andreas Möller",
    "emoji": "🤓",
    "urls": [
        "https://localheinz.com",
        "https://github.com/localheinz",
        "https://twitter.com/localheinz"
    ]
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/pull/37
     */
    public function testPrintDoesNotRemoveSpaceAroundCommaInStringValue()
    {
        $original = <<<'JSON'
{"after":"Level is greater than 9000, maybe even 9001!","around":"Really , nobody does that.","in-array":["Level is greater than 9000, maybe even 9001!","Really , nobody does that."]}
JSON;

        $expected = <<<'JSON'
{
    "after": "Level is greater than 9000, maybe even 9001!",
    "around": "Really , nobody does that.",
    "in-array": [
        "Level is greater than 9000, maybe even 9001!",
        "Really , nobody does that."
    ]
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testPrintDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInArray()
    {
        $original = \json_encode([1, '\\', 3]);

        $expected = <<<'JSON'
[
    1,
    "\\",
    3
]
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testPrintDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInObject()
    {
        $original = \json_encode(['a' => '\\']);

        $expected = <<<'JSON'
{
    "a": "\\"
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            true,
            true
        );

        $this->assertSame($expected, $printed);
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
