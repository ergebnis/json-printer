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
     * The primary objective of the adoption is
     *
     * - turn static method into an instance method
     * - allow to specify indent
     *
     * If you observe closely, the options for un-escaping unicode characters and slashes have been removed. Since this
     * package requires PHP 7, there is no need to implement this in user-land code.
     * @see http://php.net/manual/en/function.json-encode.php
     * @see http://php.net/manual/en/json.constants.php
     *
     * @param string $json
     * @param string $indent
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function print(string $json, string $indent = '    '): string
    {
        if (null === \json_decode($json) && JSON_ERROR_NONE !== \json_last_error()) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not valid JSON.',
                $json
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
        $length = \strlen($json);
        $withinStringLiteral = false;
        $stringLiteral = '';
        $noEscape = true;

        for ($i = 0; $i < $length; ++$i) {
            /**
             * Grab the next character in the string.
             */
            $character = \substr($json, $i, 1);

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
