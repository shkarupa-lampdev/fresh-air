<?php
/*
 * php-cs-fixer fix --config=.php_cs.php --verbose --show-progress=dots
 * @link https://github.com/FriendsOfPHP/PHP-CS-Fixer
 */

$finder = PhpCsFixer\Finder::create()
    ->exclude(array_merge(
        // for yii
        ['packages', 'runtime', 'vendor', 'views', 'widgets'],
        // for laravel
        ['bootstrap/cache', 'storage', 'vendor', 'resources/views', 'node_modules']
    ))
    ->in(__DIR__)
    ->name('*.php')
    ->notName(['_ide_helper.php', '_ide_helper_models.php', 'template.php'])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$rules = [
    '@PSR12' => true,
    '@Symfony' => true,
    // Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
    'align_multiline_comment' => true,
    // Each element of an array must be indented exactly once.
    'array_indentation' => true,
    // PHP arrays should be declared using the configured syntax.
    'array_syntax' => ['syntax' => 'short'],
    // Binary operators should be surrounded by space as configured.
    // 'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
    'binary_operator_spaces' => true,
    // Ensure there is no code on the same line as the PHP open tag and it is followed by a blank line.
    'blank_line_after_opening_tag' => false,
    // An empty line feed must precede any configured statement.
    'blank_line_before_statement' => [
        'statements' => [
            'switch',
            'declare',
            'throw',
            'try',
            'if',
        ],
    ],
    // Using isset($var) && multiple times should be done in one call.
    'combine_consecutive_issets' => true,
    // Calling unset on multiple items should be done in one call.
    'combine_consecutive_unsets' => true,
    // Remove extra spaces in a nullable typehint.
    'compact_nullable_typehint' => true,
    // Concatenation should be spaced according configuration.
    'concat_space' => ['spacing' => 'one'],
    // Equal sign in declare statement should be surrounded by spaces or not following configuration.
    'declare_equal_normalize' => ['space' => 'single'],
    // Add curly braces to indirect variables to make them clear to understand. Requires PHP >= 7.0.
    'explicit_indirect_variable' => true,
    // Converts implicit variables into explicit ones in double-quoted strings or heredoc syntax.
    'explicit_string_variable' => true,
    // Transforms imported FQCN parameters and return types in function arguments to short version.
    'fully_qualified_strict_types' => true,
    // Imports or fully qualifies global classes/functions/constants.
    'global_namespace_import' => false,
    // Heredoc/nowdoc content must be properly indented.
    'heredoc_indentation' => true,
    // Pre- or post-increment and decrement operators should be used if possible.
    'increment_style' => false,
    // All PHP files must use same line ending.
    'line_ending' => false,
    // In method arguments and method call, there MUST NOT be a space before each comma and there MUST be
    // one space after each comma. Argument lists MAY be split across multiple lines, where each subsequent
    // line is indented once. When doing so, the first item in the list MUST be on the next line, and there
    // MUST be only one argument per line.
    'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
    // Method chaining MUST be properly indented. Method chaining with different levels of indentation is not supported.
    'method_chaining_indentation' => true,
    // DocBlocks must start with two asterisks, multiline comments must start with a single asterisk,
    // after the opening slash. Both must end with a single asterisk before the closing slash.
    'multiline_comment_opening_closing' => true,
    // Forbid multi-line whitespace before the closing semicolon or move the semicolon to the new line
    // for chained calls.
    'multiline_whitespace_before_semicolons' => true,
    // Replace die() with exit()
    'no_alias_language_construct_call' => false,
    // Replace control structure alternative syntax to use braces.
    'no_alternative_syntax' => true,
    // Removes extra blank lines and/or blank lines following configuration.
    'no_extra_blank_lines' => [
        'tokens' => [
            'break',
            'continue',
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'throw',
            'use',
        ],
    ],
    // Either language construct print or echo should be used.
    'no_mixed_echo_print' => false,
    // Properties MUST not be explicitly initialized with null.
    'no_null_property_initialization' => true,
    // Replace short-echo <?= with long format <?php echo syntax.
    'echo_tag_syntax' => ['format' => 'long'],
    // Replaces superfluous elseif with if.
    'no_superfluous_elseif' => true,
    // Removes @param and @return tags that don't provide any useful information.
    'no_superfluous_phpdoc_tags' => false,
    // There should not be useless else cases.
    // 'no_useless_else' => true,
    // There should not be an empty return statement at the end of a function.
    'no_useless_return' => true,
    // Orders the elements of classes/interfaces/traits.
    'ordered_class_elements' => true,
    // Ordering use statements.
    'ordered_imports' => true,
    // PHPDoc should contain @param for all params.
    'phpdoc_add_missing_param_annotation' => true,
    // Annotations in PHPDoc should be ordered so that @param annotations come first,
    // then @throws annotations, then @return annotations.
    'phpdoc_order' => true,
    // Removes extra blank lines after summary and after description in PHPDoc.
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    // Sorts PHPDoc types.
    'phpdoc_types_order' => true,
    // Enforce camel (or snake) case for PHPUnit test methods, following configuration.
    'php_unit_method_casing' => false,
    // Converts protected variables and methods to private where possible.
    'protected_to_private' => false,
    // Throwing exception must be done in single line.
    'single_line_throw' => false,
    // Convert double quotes to single quotes for simple strings.
    'single_quote' => false,
    // Increment and decrement operators should be used if possible.
    'standardize_increment' => false,
    // Use null coalescing operator ?? where possible. Requires PHP >= 7.0.
    'ternary_to_null_coalescing' => true,
    // PHP multi-line arrays should have a trailing comma.
    'trailing_comma_in_multiline' => true,
    // A single space or none should be around union type operator.
    'types_spaces' => ['space' => 'single'],
    // Write conditions in Yoda style (true), non-Yoda style (false) or
    // ignore those conditions (null) based on configuration.
    'yoda_style' => false,
];

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');
