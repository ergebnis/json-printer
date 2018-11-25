<?php

use Localheinz\PhpCsFixer\Config;

$header = <<<EOF
Copyright (c) 2018 Andreas Möller

For the full copyright and license information, please view
the LICENSE file that was distributed with this source code.

@see https://github.com/localheinz/json-printer
EOF;

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php71($header), [
    'escape_implicit_backslashes' => false,
    'mb_str_functions' => false,
]);

$config->getFinder()->in(__DIR__);

$cacheDir = \getenv('TRAVIS') ? \getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;
