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

    public function testPrintRejectsInvalidJson()
    {
        $original = $this->faker()->realText();

        $printer = new Printer();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            '"%s" is not valid JSON.',
            $original
        ));

        $printer->print($original);
    }

    /**
     * @dataProvider providerInvalidIndent
     *
     * @param string $indent
     */
    public function testPrintRejectsInvalidIndent(string $indent)
    {
        $original = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $printer = new Printer();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            '"%s" is not a valid indent.',
            $indent
        ));

        $printer->print(
            $original,
            $indent
        );
    }

    public function providerInvalidIndent(): \Generator
    {
        $values = [
            'not-whitespace' => $this->faker()->sentence,
            'contains-line-feed' => " \n ",
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    public function testPrintPrintsPretty()
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

        $printed = $printer->print($original);

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeUnicode()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $indent = '    ';

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
            $indent,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeSlashes()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $indent = '    ';

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
            $indent,
            false,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeUnicodeAndUnEscapeSlashes()
    {
        $original = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;

        $indent = '    ';

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
            $indent,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyIdempotently()
    {
        $original = <<<'JSON'
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

        $printed = $printer->print($original);

        $this->assertSame($original, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeUnicodeIdempotently()
    {
        $original = <<<'JSON'
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

        $indent = '    ';

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            $indent,
            true
        );

        $this->assertSame($original, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeSlashesIdempotently()
    {
        $original = <<<'JSON'
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

        $indent = '    ';

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            $indent,
            false,
            true
        );

        $this->assertSame($original, $printed);
    }

    public function testPrintPrintsPrettyWithUnEscapeUnicodeAndUnEscapeSlashesIdempotently()
    {
        $original = <<<'JSON'
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

        $indent = '    ';

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            $indent,
            true,
            true
        );

        $this->assertSame($original, $printed);
    }

    public function testPrintCollapsesEmptyArray()
    {
        $original = <<<'JSON'
[



        ]
JSON;

        $expected = <<<'JSON'
[]
JSON;

        $printer = new Printer();

        $printed = $printer->print($original);

        $this->assertSame($expected, $printed);
    }

    public function testPrintCollapsesEmptyObject()
    {
        $original = <<<'JSON'
{



        }
JSON;

        $expected = <<<'JSON'
{}
JSON;

        $printer = new Printer();

        $printed = $printer->print($original);

        $this->assertSame($expected, $printed);
    }

    public function testPrintCollapsesEmptyComplex()
    {
        $original = <<<'JSON'
{
            "foo":          {
    
    
}   ,
    "bar": [                                ]
        }
JSON;

        $expected = <<<'JSON'
{
    "foo": {},
    "bar": []
}
JSON;

        $printer = new Printer();

        $printed = $printer->print($original);

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/composer/composer/blob/1.6.0/tests/Composer/Test/Json/JsonFormatterTest.php#L20-L34
     */
    public function testPrintWithUnEscapeUnicodeWithPrependedSlash()
    {
        if (!\extension_loaded('mbstring')) {
            $this->markTestSkipped('Test requires the mbstring extension');
        }

        $original = '"' . \chr(92) . \chr(92) . \chr(92) . 'u0119"';
        $indent = '    ';

        $expected = '34+92+92+196+153+34';

        $printer = new Printer();

        $printed = $printer->print(
            $original,
            $indent,
            true,
            true
        );

        $characterCodes = \implode('+', \array_map(function (string $character) {
            return \ord($character);
        }, \str_split($printed)));

        $this->assertSame($expected, $characterCodes);
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

        $printed = $printer->print($original);

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

        $printed = $printer->print($original);

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

        $printed = $printer->print($original);

        $this->assertSame($expected, $printed);
    }
}
