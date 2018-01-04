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

final class JsonFormatter
{
    /**
     * This code is adopted from composer/composer (originally licensed under MIT by Nils Adermann <naderman@naderman.de>
     * and Jordi Boggiano <j.boggiano@seld.be>), who adopted it from a blog post by Dave Perrett (originally licensed
     * under MIT by Dave Perrett <mail@recursive-design.com>).
     *
     * @see https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php#L25-L126
     * @see https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
     *
     * @param string $json
     * @param bool   $unescapeUnicode
     * @param bool   $unescapeSlashes
     *
     * @return string
     */
    public static function format(string $json, bool $unescapeUnicode, bool $unescapeSlashes): string
    {
        $result = '';
        $pos = 0;
        $strLen = \strlen($json);
        $indentStr = '    ';
        $newLine = "\n";
        $outOfQuotes = true;
        $buffer = '';
        $noescape = true;

        for ($i = 0; $i < $strLen; ++$i) {
            // Grab the next character in the string
            $char = \substr($json, $i, 1);

            // Are we inside a quoted string?
            if ('"' === $char && $noescape) {
                $outOfQuotes = !$outOfQuotes;
            }

            if (!$outOfQuotes) {
                $buffer .= $char;
                $noescape = '\\' === $char ? !$noescape : true;

                continue;
            }

            if ('' !== $buffer) {
                if ($unescapeSlashes) {
                    $buffer = \str_replace('\\/', '/', $buffer);
                }

                if ($unescapeUnicode && \function_exists('mb_convert_encoding')) {
                    // https://stackoverflow.com/questions/2934563/how-to-decode-unicode-escape-sequences-like-u00ed-to-proper-utf-8-encoded-cha
                    $buffer = \preg_replace_callback('/(\\\\+)u([0-9a-f]{4})/i', function (array $match) {
                        $l = \strlen($match[1]);

                        if ($l % 2) {
                            return \str_repeat('\\', $l - 1) . \mb_convert_encoding(
                                \pack('H*', $match[2]),
                                'UTF-8',
                                'UCS-2BE'
                            );
                        }

                        return $match[0];
                    }, $buffer);
                }

                $result .= $buffer . $char;
                $buffer = '';

                continue;
            }

            if (':' === $char) {
                // Add a space after the : character
                $char .= ' ';
            } elseif (('}' === $char || ']' === $char)) {
                --$pos;
                $prevChar = \substr($json, $i - 1, 1);

                if ('{' !== $prevChar && '[' !== $prevChar) {
                    // If this character is the end of an element,
                    // output a new line and indent the next line
                    $result .= $newLine;

                    for ($j = 0; $j < $pos; ++$j) {
                        $result .= $indentStr;
                    }
                } else {
                    // Collapse empty {} and []
                    $result = \rtrim($result);
                }
            }

            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            if (',' === $char || '{' === $char || '[' === $char) {
                $result .= $newLine;

                if ('{' === $char || '[' === $char) {
                    ++$pos;
                }

                for ($j = 0; $j < $pos; ++$j) {
                    $result .= $indentStr;
                }
            }
        }

        return $result;
    }
}
