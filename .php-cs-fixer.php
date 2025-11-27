<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'bootstrap/cache',
        'storage',
        'vendor',
        'node_modules',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRules([
        // PSR-12 base
        '@PSR12' => true,

        // Strict types
        'declare_strict_types' => true,
        'strict_param' => true,

        // Array syntax
        'array_syntax' => ['syntax' => 'short'],
        'no_whitespace_before_comma_in_array' => true,
        'whitespace_after_comma_in_array' => true,
        'trim_array_spaces' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],

        // Imports
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'no_leading_import_slash' => true,
        'single_import_per_statement' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],

        // Visibility
        'visibility_required' => [
            'elements' => ['property', 'method', 'const'],
        ],

        // Class structure
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
            ],
        ],
        'no_blank_lines_after_class_opening' => true,
        'single_class_element_per_statement' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],

        // Strings
        'single_quote' => true,
        'explicit_string_variable' => true,

        // PHPDoc
        'no_blank_lines_after_phpdoc' => true,
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_indent' => true,
        'phpdoc_scalar' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => false,
            'remove_inheritdoc' => true,
        ],

        // Spacing
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'concat_space' => ['spacing' => 'one'],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'no_extra_blank_lines' => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'throw',
                'use',
            ],
        ],

        // Control structures
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_braces' => true,

        // Other
        'cast_spaces' => ['space' => 'single'],
        'lowercase_cast' => true,
        'short_scalar_cast' => true,
        'no_empty_statement' => true,
        'no_unneeded_final_method' => true,
        'semicolon_after_instruction' => true,
        'ternary_operator_spaces' => true,
        'unary_operator_spaces' => ['only_dec_inc' => false],

        // Null safety
        'nullable_type_declaration_for_default_null_value' => true,

        // Final classes
        'final_class' => false, // Don't force final, but prefer it
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile('.php-cs-fixer.cache');
