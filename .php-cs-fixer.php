<?php

/*
 * This document has been initially generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:3.5.0|configurator
 * and then adapted be our needs
 */

return (new PhpCsFixer\Config)
    ->setFinder((new PhpCsFixer\Finder)
        ->in([
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ])
        ->notPath('DependencyInjection/Configuration.php')
    )
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,

        // declare strict types must be on first line after opening tag
        'blank_line_after_opening_tag' => false, // overwrite @Symfony
        'linebreak_after_opening_tag' => false, // overwrite @Symfony
        'declare_strict_types' => true, // custom

        // we want spaces
        'concat_space' => ['spacing' => 'one'],

        // we want snake_case for test method names to increase readability
        'php_unit_method_casing' => ['case' => 'snake_case'], // overwrite @Symfony
    ]);
