<?php

declare(strict_types=1);

/**
 * Copyright (c) 2018-2026 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-printer
 */

namespace Ergebnis\Json\Printer;

final class Printer implements PrinterInterface
{
    /**
     * This code is adopted from composer/composer (originally licensed under MIT by Nils Adermann <naderman@naderman.de>
     * and Jordi Boggiano <j.boggiano@seld.be>), who adopted it from a blog post by Dave Perrett (originally licensed
     * under MIT by Dave Perrett <mail@recursive-design.com>).
     *
     * The primary objective of the adoption is
     *
     * - turn static method into an instance method
     * - allow to specify indent
     * - allow to specify new-line character sequence
     *
     * If you observe closely, the options for un-escaping unicode characters and slashes have been removed. Since this
     * package requires PHP 7, there is no need to implement this in user-land code.
     *
     * @see https://github.com/composer/composer/blob/1.6.0/src/Composer/Json/JsonFormatter.php#L25-L126
     * @see https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
     * @see http://php.net/manual/en/function.json-encode.php
     * @see http://php.net/manual/en/json.constants.php
     *
     * @throws \InvalidArgumentException
     */
    public function print(
        string $json,
        string $indent = '    ',
        string $newLine = \PHP_EOL
    ): string {
        try {
            \json_decode(
                $json,
                false,
                512,
                \JSON_THROW_ON_ERROR,
            );
        } catch (\JsonException $exception) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not valid JSON.',
                $json,
            ));
        }

        if (1 !== \preg_match('/^( +|\t+)\z/', $indent)) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not a valid indent.',
                $indent,
            ));
        }

        if (1 !== \preg_match('/^(?>\r\n|\n|\r)\z/', $newLine)) {
            throw new \InvalidArgumentException(\sprintf(
                '"%s" is not a valid new-line character sequence.',
                $newLine,
            ));
        }

        $printed = '';
        $indentLevel = 0;
        $length = \strlen($json);
        $withinStringLiteral = false;
        $stringLiteral = '';
        $noEscape = true;
        $afterOpeningBracket = false;

        for ($i = 0; $i < $length; ++$i) {
            /**
             * Grab the next character in the string.
             */
            $character = $json[$i];

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
                /**
                 * Output the new line deferred after "{" and "[" before the string literal.
                 */
                if ($afterOpeningBracket) {
                    $printed .= $newLine . \str_repeat($indent, $indentLevel);
                    $afterOpeningBracket = false;
                }

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
             * Collapse empty {} and [].
             */
            if ($afterOpeningBracket) {
                $afterOpeningBracket = false;

                if ('}' === $character || ']' === $character) {
                    --$indentLevel;

                    $printed .= $character;

                    continue;
                }

                $printed .= $newLine . \str_repeat($indent, $indentLevel);
            }

            /**
             * Ensure space after ":" character.
             */
            if (':' === $character) {
                $printed .= ': ';

                continue;
            }

            /**
             * Output a new line after "," character and indent the next line.
             */
            if (',' === $character) {
                $printed .= $character . $newLine . \str_repeat($indent, $indentLevel);

                continue;
            }

            /**
             * Defer the new line after "{" and "[" until we know whether the next character closes them.
             */
            if ('{' === $character || '[' === $character) {
                ++$indentLevel;

                $printed .= $character;
                $afterOpeningBracket = true;

                continue;
            }

            /**
             * Output a new line before "}" and "]" and indent it.
             */
            if ('}' === $character || ']' === $character) {
                --$indentLevel;

                $printed .= $newLine . \str_repeat($indent, $indentLevel);
            }

            $printed .= $character;
        }

        return $printed;
    }
}
