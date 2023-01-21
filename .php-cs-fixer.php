<?php

return (new PhpCsFixer\Config)
    ->setFinder((new PhpCsFixer\Finder)
        ->in(__DIR__)
        ->notPath('DependencyInjection/Configuration.php')
    )
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,

        // we want declare-strict on the first line of the file
        'blank_line_after_opening_tag' => false,
        'linebreak_after_opening_tag' => false,

        // we want spaces
        'concat_space' => ['spacing' => 'one'],
    ]);
