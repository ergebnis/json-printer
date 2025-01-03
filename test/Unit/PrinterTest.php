<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018-2025 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-printer
 */

namespace Ergebnis\Json\Printer\Test\Unit;

use Ergebnis\Json\Printer\Printer;
use Ergebnis\Json\Printer\Test;
use PHPUnit\Framework;

/**
 * @covers \Ergebnis\Json\Printer\Printer
 */
final class PrinterTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testPrintRejectsInvalidJson(): void
    {
        $json = self::faker()->realText();

        $printer = new Printer();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            '"%s" is not valid JSON.',
            $json,
        ));

        $printer->print($json);
    }

    /**
     * @dataProvider provideInvalidIndent
     */
    public function testPrintRejectsInvalidIndent(string $indent): void
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $printer = new Printer();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            '"%s" is not a valid indent.',
            $indent,
        ));

        $printer->print(
            $json,
            $indent,
        );
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function provideInvalidIndent(): iterable
    {
        $values = [
            'string-contains-line-feed' => " \n ",
            'string-mixed-space-and-tab' => " \t",
            'string-not-whitespace' => self::faker()->sentence(),
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    /**
     * @dataProvider provideInvalidNewLine
     */
    public function testPrintRejectsInvalidNewLine(string $newLine): void
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;
        $indent = '    ';

        $printer = new Printer();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            '"%s" is not a valid new-line character sequence.',
            $newLine,
        ));

        $printer->print(
            $json,
            $indent,
            $newLine,
        );
    }

    /**
     * @return \Generator<int, array{0: string}>
     */
    public static function provideInvalidNewLine(): iterable
    {
        $values = [
            "\t",
            " \r ",
            " \r\n ",
            " \n ",
            ' ',
            "\f",
            "\x0b",
            "\x85",
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testPrintPrintsPretty(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyWithIndent(): void
    {
        $json = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;
        $indent = '  ';

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
            $json,
            $indent,
        );

        self::assertSame($expected, $printed);
    }

    /**
     * @dataProvider provideNewLine
     */
    public function testPrintPrintsPrettyWithIndentAndNewLine(string $newLine): void
    {
        $json = <<<'JSON'
{"name":"Andreas M\u00f6ller","emoji":"🤓","urls":["https:\/\/localheinz.com","https:\/\/github.com\/localheinz","https:\/\/twitter.com\/localheinz"]}
JSON;
        $indent = '  ';

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

        $expectedWithNewLine = \str_replace(
            \PHP_EOL,
            $newLine,
            $expected,
        );

        $printer = new Printer();

        $printed = $printer->print(
            $json,
            $indent,
            $newLine,
        );

        self::assertSame($expectedWithNewLine, $printed);
    }

    /**
     * @see https://nikic.github.io/2011/12/10/PCRE-and-newlines.html
     *
     * @return \Generator<int, array{0: string}>
     */
    public static function provideNewLine(): iterable
    {
        $values = [
            "\r\n",
            "\n",
            "\r",
        ];

        foreach ($values as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    public function testPrintPrintsPrettyButDoesNotUnEscapeUnicodeCharactersAndSlashes(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyButDoesNotEscapeUnicodeCharactersAndSlashes(): void
    {
        $json = <<<'JSON'
{"name":"Andreas Möller","emoji":"🤓","urls":["https://localheinz.com","https://github.com/localheinz","https://twitter.com/localheinz"]}
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

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    public function testPrintPrintsPrettyIdempotently(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame($json, $printed);
    }

    public function testPrintRemovesTrailingEmptyLines(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame(\trim($json), $printed);
    }

    public function testPrintCollapsesEmptyArray(): void
    {
        $json = <<<'JSON'
[



        ]
JSON;

        $expected = <<<'JSON'
[]
JSON;

        $printer = new Printer();

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    public function testPrintCollapsesEmptyObject(): void
    {
        $json = <<<'JSON'
{



        }
JSON;

        $expected = <<<'JSON'
{}
JSON;

        $printer = new Printer();

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    public function testPrintCollapsesEmptyComplex(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/pull/37
     */
    public function testPrintDoesNotRemoveSpaceAroundCommaInStringValue(): void
    {
        $json = <<<'JSON'
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

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testPrintDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInArray(): void
    {
        /** @var string $json */
        $json = \json_encode([1, '\\', 3]);

        $expected = <<<'JSON'
[
    1,
    "\\",
    3
]
JSON;

        $printer = new Printer();

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testPrintDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInObject(): void
    {
        /** @var string $json */
        $json = \json_encode(['a' => '\\']);

        $expected = <<<'JSON'
{
    "a": "\\"
}
JSON;

        $printer = new Printer();

        $printed = $printer->print($json);

        self::assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/ergebnis/json-printer/issues/675
     */
    public function testPrintPrintsJsonWhenValueContainsJsonString(): void
    {
        $json = <<<'JSON'
{
  "type": "auth-token",
  "error": "Server error: `POST https://xxxx.xxxxx.net/sms/send` resulted in a `500 Internal Server Error` response:\n{\"status\":106000,\"description\":\"Unknown error\",\"translatedDescription\":null}",
  "queue": "auth",
  "token": "V25EP",
  "origin": "foobar",
  "identifier": null,
  "recipients": [
    {
      "email": "blabla@hotmail.com",
      "mobile": "11111111",
      "mobile_country_code": "0047"
    }
  ],
  "request_ip": "11.111.11.111",
  "destination": "004711111111",
  "consignor_id": null,
  "sms_error_code": null,
  "sms_error_description": null
}
JSON;

        $printer = new Printer();

        $printed = $printer->print(
            $json,
            \str_repeat(' ', 2),
        );

        self::assertSame($json, $printed);
    }
}
