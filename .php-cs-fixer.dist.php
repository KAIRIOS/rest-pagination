<?php

$header = <<<'EOF'
Ce fichier est la propriété de Kairios
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'header_comment' => ['header' => $header]
    ])
    ->setFinder($finder)
;

return $config;
