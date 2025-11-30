<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->exclude([
        'storage',
        'vendor',
        'node_modules',
        'public',
    ])
    ->name('*.php')
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true);

return (new Config())
    // enable the strictest and risky rules for best‑practice code‑quality
    ->setRiskyAllowed(true)
    ->setIndent("    ")               // PSR‑12: 4‑space indent
    ->setLineEnding("\n")            // Unix line endings
    ->setFinder($finder)
    ->setRules([
        // complete rule sets
        '@PSR12'                      => true,
        '@Symfony'                    => true,
        '@Symfony:risky'              => true,
        '@PHP82Migration'             => true,
        '@PHP82Migration:risky'       => true,
        '@PHPUnit100Migration:risky'  => true,
        '@DoctrineAnnotation'         => true,

        // additional strictness and best‑practice fixers
        'declare_strict_types'                     => true,
        'strict_comparison'                        => true,
        'strict_param'                             => true,
        'static_lambda'                            => true,
        'date_time_immutable'                      => true,
        'final_public_method_for_abstract_class'   => true,
        'final_internal_class'                     => true,
        'self_static_accessor'                     => true,
        'protected_to_private'                     => true,
        'no_superfluous_phpdoc_tags'               => ['remove_inheritdoc' => true],
        'phpdoc_to_param_type'                     => true,
        'phpdoc_to_property_type'                  => false,
        'phpdoc_to_return_type'                    => true,
        'psr_autoloading'                          => ['dir' => __DIR__.'/app'],
        'ordered_class_elements'                   => [
            'order' => [
                'use_trait', 'constant_public', 'constant_protected', 'constant_private',
                'property_public', 'property_protected', 'property_private',
                'construct', 'destruct', 'magic',
                'method_public', 'method_protected', 'method_private',
            ],
            'sort_algorithm' => 'alpha'
        ],
        'ordered_imports'                          => [
            'imports_order'  => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'global_namespace_import'                  => [
            'import_classes'   => true,
            'import_functions' => true,
            'import_constants' => true,
        ],
        'no_unused_imports'                        => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'single_quote'                             => true,
        'explicit_string_variable'                => true,
        'modernize_strpos'                        => true,
        'modernize_types_casting'                 => true,
        'no_useless_sprintf'                      => true,
        'simplified_if_return'                    => true,
        'combine_consecutive_issets'              => true,
        'combine_consecutive_unsets'              => true,
        'multiline_comment_opening_closing'       => true,
        'no_alternative_syntax'                   => true,
        'no_unreachable_default_argument_value'   => true,
        'no_useless_return'                       => true,
        'single_line_throw'                       => false, // allow multi‑line for readability
        'yoda_style'                              => false, // disable yoda conditions
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align',          // or 'align_single_space'
                '='  => 'align_single_space',  // (optional) aligns assignments, too
            ],
        ],
    ]);

