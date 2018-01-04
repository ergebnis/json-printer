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

    public function testFormatFormatsArrayPretty()
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas M\u00f6ller",
    "🤓",
    "https:\/\/localheinz.com"
]
JSON;

        $printed = JsonFormatter::format(
            $json,
            false,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsArrayPrettyWithUnescapeUnicode()
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas Möller",
    "🤓",
    "https:\/\/localheinz.com"
]
JSON;

        $printed = JsonFormatter::format(
            $json,
            true,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsArrayPrettyWithUnescapeSlashes()
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas M\u00f6ller",
    "🤓",
    "https://localheinz.com"
]
JSON;

        $printed = JsonFormatter::format(
            $json,
            false,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsArrayPrettyWithUnescapeUnicodeAndUnescapeSlashes()
    {
        $json = <<<'JSON'
["Andreas M\u00f6ller","🤓","https:\/\/localheinz.com"]
JSON;

        $expected = <<<'JSON'
[
    "Andreas Möller",
    "🤓",
    "https://localheinz.com"
]
JSON;

        $printed = JsonFormatter::format(
            $json,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsObjectPretty()
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

        $printed = JsonFormatter::format(
            $json,
            false,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsObjectPrettyWithUnescapeUnicode()
    {
        $json = <<<'JSON'
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

        $printed = JsonFormatter::format(
            $json,
            true,
            false
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsObjectPrettyWithUnescapeSlashes()
    {
        $json = <<<'JSON'
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

        $printed = JsonFormatter::format(
            $json,
            false,
            true
        );

        $this->assertSame($expected, $printed);
    }

    public function testFormatFormatsObjectPrettyWithUnescapeUnicodeAndUnescapeSlashes()
    {
        $json = <<<'JSON'
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

        $printed = JsonFormatter::format(
            $json,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/pull/37
     */
    public function testFormatDoesNotRemoveSpaceAroundCommaInStringValue()
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

        $printed = JsonFormatter::format(
            $json,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testFormatDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInArray()
    {
        $json = \json_encode([1, '\\', 3]);

        $expected = <<<'JSON'
[
    1,
    "\\",
    3
]
JSON;

        $printed = JsonFormatter::format(
            $json,
            true,
            true
        );

        $this->assertSame($expected, $printed);
    }

    /**
     * @see https://github.com/zendframework/zend-json/blob/release-3.0.0/test/JsonTest.php#L964-L975
     */
    public function testFormatDoesNotConsiderDoubleQuoteFollowingEscapedBackslashAsEscapedInObject()
    {
        $json = \json_encode(['a' => '\\']);

        $expected = <<<'JSON'
{
    "a": "\\"
}
JSON;

        $printed = JsonFormatter::format(
            $json,
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
