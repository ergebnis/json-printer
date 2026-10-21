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

namespace Ergebnis\Json\Printer\Test\Benchmark;

use Ergebnis\Json\Printer\Printer;

final class PrinterBench
{
    private string $json;
    private Printer $printer;

    /**
     * @param array{count: int, item: array<string, mixed>} $parameters
     */
    public function setUp(array $parameters): void
    {
        $this->json = \json_encode(
            \array_fill(
                0,
                $parameters['count'],
                $parameters['item'],
            ),
            \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
        );
        $this->printer = new Printer();
    }

    /**
     * @return \Generator<string, array{count: int, item: array<string, mixed>}>
     */
    public function provideItems(): iterable
    {
        $texts = [
            'html-ascii' => '<p>Moller aou code &amp; more text here.</p>',
            'html-non-ascii' => '<p>Möller äöü code &amp; more text here.</p>',
        ];

        foreach ($texts as $name => $text) {
            $counts = [
                10,
                20,
                40,
            ];

            foreach ($counts as $count) {
                $key = \sprintf(
                    '%s-%d',
                    $name,
                    $count,
                );

                yield $key => [
                    'count' => $count,
                    'item' => [
                        'content_html' => \str_repeat(
                            $text,
                            50,
                        ),
                    ],
                ];
            }
        }

        $counts = [
            2500,
            5000,
            10000,
        ];

        foreach ($counts as $count) {
            $key = \sprintf(
                'objects-%d',
                $count,
            );

            yield $key => [
                'count' => $count,
                'item' => [
                    'id' => 1,
                    'tags' => [],
                ],
            ];
        }
    }

    /**
     * @BeforeMethods("setUp")
     *
     * @ParamProviders("provideItems")
     */
    public function benchPrint(): void
    {
        $this->printer->print(
            $this->json,
            '  ',
        );
    }
}
