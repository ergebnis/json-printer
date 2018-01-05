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

final class Printer implements PrinterInterface
{
    /**
     * This code is adopted from composer/composer (originally licensed under MIT by Nils Adermann <naderman@naderman.de>
     * and Jordi Boggiano <j.boggiano@seld.be>), who adopted it from a blog post by Dave Perrett (originally licensed
     * under MIT by Dave Perrett <mail@recursive-design.com>).
     *
     * @see https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php#L25-L126
     * @see https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
     *
     * @param string $original
     * @param string $indent
     * @param bool   $unEscapeUnicode
     * @param bool   $unEscapeSlashes
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function print(
        string $original,
        string $indent = '    ',
        bool $unEscapeUnicode = false,
        bool $unEscapeSlashes = false
    ): string {
        if (null === \json_decode($original) && JSON_ERROR_NONE !== \json_last_error()) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not valid JSON.',
                $original
            ));
        }

        if (1 !== \preg_match('/^[ \t]+$/', $indent)) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not a valid indent.',
                $indent
            ));
        }

        $printed = '';
        $indentLevel = 0;
        $length = \strlen($original);
        $withinStringLiteral = false;
        $stringLiteral = '';
        $noEscape = true;

        for ($i = 0; $i < $length; ++$i) {
            /**
             * Grab the next character in the string.
             */
            $character = \substr($original, $i, 1);

            /**
             * Are we inside a quoted string literal?
             */
            if ('"' === $character && $noEscape) {
                $withinStringLiteral = !$withinStringLiteral;
            }

            /**
             * Collect characters if we are inside a quoted string literal.
             */
            if ($withinStringLiteral) {
                $stringLiteral .= $character;
                $noEscape = '\\' === $character ? !$noEscape : true;

                continue;
            }

            /**
             * Process string literal if we are about to leave it.
             */
            if ('' !== $stringLiteral) {
                /**
                 * Un-escape slashes in string literal.
                 */
                if ($unEscapeSlashes) {
                    $stringLiteral = \str_replace('\\/', '/', $stringLiteral);
                }

                /**
                 * Un-escape unicode in string literal.
                 */
                if ($unEscapeUnicode && \function_exists('mb_convert_encoding')) {
                    /**
                     * @see https://stackoverflow.com/questions/2934563/how-to-decode-unicode-escape-sequences-like-u00ed-to-proper-utf-8-encoded-cha
                     */
                    $stringLiteral = \preg_replace_callback('/(\\\\+)u([0-9a-f]{4})/i', function (array $match) {
                        $length = \strlen($match[1]);

                        if ($length % 2) {
                            return \str_repeat('\\', $length - 1) . \mb_convert_encoding(
                                \pack('H*', $match[2]),
                                'UTF-8',
                                'UCS-2BE'
                            );
                        }

                        return $match[0];
                    }, $stringLiteral);
                }

                $printed .= $stringLiteral . $character;
                $stringLiteral = '';

                continue;
            }

            /**
             * Ignore whitespace outside of string literal.
             */
            if ('' === \trim($character)) {
                continue;
            }

            /**
             * Ensure space after ":" character.
             */
            if (':' === $character) {
                $printed .= ': ';

                continue;
            }

            /**
             * Output a new line after "," character and and indent the next line.
             */
            if (',' === $character) {
                $printed .= $character . PHP_EOL . \str_repeat($indent, $indentLevel);

                continue;
            }

            /**
             * Output a new line after "{" and "[" and indent the next line.
             */
            if ('{' === $character || '[' === $character) {
                ++$indentLevel;

                $printed .= $character . PHP_EOL . \str_repeat($indent, $indentLevel);

                continue;
            }

            /**
             * Output a new line after "}" and "]" and indent the next line.
             */
            if ('}' === $character || ']' === $character) {
                --$indentLevel;

                $trimmed = \rtrim($printed);
                $previousNonWhitespaceCharacter = \substr($trimmed, -1);

                /**
                 * Collapse empty {} and [].
                 */
                if ('{' === $previousNonWhitespaceCharacter || '[' === $previousNonWhitespaceCharacter) {
                    $printed = $trimmed . $character;

                    continue;
                }

                $printed .= PHP_EOL . \str_repeat($indent, $indentLevel);
            }

            $printed .= $character;
        }

        return $printed;
    }
}
