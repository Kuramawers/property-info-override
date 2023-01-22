<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Classes\DuplicateClassNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\CallTimePassByReferenceSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\NestingLevelSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\ConstructorNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\BacktickOperatorSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\CharacterBeforePHPOpeningTagSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DeprecatedFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowAlternativePHPTagsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowShortOpenTagSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DiscourageGotoSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseTypeSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\NoSilencedErrorsSniff;
use PHP_CodeSniffer\Standards\MySource\Sniffs\Objects\AssignThisSniff;
use PHP_CodeSniffer\Standards\PSR12\Sniffs\ControlStructures\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\NamespaceDeclarationSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\UseDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayBracketSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassFileNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\DuplicatePropertySniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\LowercaseClassKeywordsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\SelfMemberReferenceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\FunctionDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Functions\MultiLineFunctionDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\IncrementDecrementUsageSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\ValidLogicalOperatorsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\DisallowMultipleAssignmentsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\DiscouragedFunctionsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\EvalSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\GlobalKeywordSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\LowercasePHPFunctionsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\NonExecutableCodeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MemberVarScopeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MethodScopeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\StaticThisUsageSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Strings\DoubleQuoteUsageSniff;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToReturnTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use SlevomatCodingStandard\Sniffs\Classes\TraitUseSpacingSniff;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/php-cs-fixer.php');
    $ecsConfig->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/symfony.php');
    $ecsConfig->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/psr12.php');

    $services = $ecsConfig->services();

    $services->set(ArrayBracketSpacingSniff::class);
    $services->set(AssignThisSniff::class);
    $services->set(BacktickOperatorSniff::class);
    $services->set(CallTimePassByReferenceSniff::class);
    $services->set(CharacterBeforePHPOpeningTagSniff::class);
    $services->set(ClassDeclarationSniff::class);
    $services->set(ClassFileNameSniff::class);
    $services->set(CommentedOutCodeSniff::class);
    $services->set(ConstructorNameSniff::class);
    $services->set(ControlStructureSpacingSniff::class);
    $services->set(DeclareStrictTypesFixer::class);
    $services->set(DeprecatedFunctionsSniff::class);
    $services->set(DisallowAlternativePHPTagsSniff::class);
    $services->set(DisallowLongArraySyntaxSniff::class);
    $services->set(DisallowMultipleAssignmentsSniff::class);
    $services->set(DisallowShortOpenTagSniff::class);
    $services->set(DiscourageGotoSniff::class);
    $services->set(DiscouragedFunctionsSniff::class);
    $services->set(DoubleQuoteUsageSniff::class);
    $services->set(DuplicateClassNameSniff::class);
    $services->set(DuplicatePropertySniff::class);
    $services->set(EvalSniff::class);
    $services->set(FunctionCallArgumentSpacingSniff::class);
    $services->set(FunctionDeclarationSniff::class);
    $services->set(GlobalKeywordSniff::class);
    $services->set(GlobalNamespaceImportFixer::class)
        ->call(
            'configure',
            [[
                'import_classes' => false,
                'import_constants' => false,
                'import_functions' => false,
            ]]
        );
    $services->set(NativeFunctionInvocationFixer::class)
        ->call(
            'configure',
            [[
                'include' => ['@all'],
                'scope' => 'namespaced',
                'strict' => true,
            ]]
        );
    $services->set(IncrementDecrementUsageSniff::class);
    $services->set(LineLengthFixer::class)
        ->call(
            'configure',
            [[
                'line_length' => 120,
                'inline_short_lines' => false,
            ]]
        );
    $services->set(LowerCaseConstantSniff::class);
    $services->set(LowerCaseKeywordSniff::class);
    $services->set(LowerCaseTypeSniff::class);
    $services->set(LowercaseClassKeywordsSniff::class);
    $services->set(LowercasePHPFunctionsSniff::class);
    $services->set(MemberVarScopeSniff::class);
    $services->set(MethodArgumentSpaceFixer::class)
        ->call('configure', [[
            'on_multiline' => 'ensure_fully_multiline',
        ]]);
    $services->set(MethodDeclarationSniff::class);
    $services->set(MethodScopeSniff::class);
    $services->set(MultiLineFunctionDeclarationSniff::class);
    $services->set(NamespaceDeclarationSniff::class);
    $services->set(NestingLevelSniff::class)
        ->property('absoluteNestingLevel', 6);
    $services->set(NoSilencedErrorsSniff::class);
    $services->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call(
            'configure',
            [['allow_mixed' => true]]
        );
    $services->set(NoUnusedImportsFixer::class);
    $services->set(NonExecutableCodeSniff::class);
    $services->set(NullableTypeDeclarationForDefaultNullValueFixer::class);
    $services->set(PhpdocToReturnTypeFixer::class);
    $services->set(PhpUnitTestCaseStaticMethodCallsFixer::class)
        ->call(
            'configure',
            [['call_type' => 'self']]
        );
    $services->set(SelfMemberReferenceSniff::class);
    $services->set(StandaloneLineInMultilineArrayFixer::class);
    $services->set(StaticThisUsageSniff::class);
    $services->set(StrictComparisonFixer::class);
    $services->set(TraitUseSpacingSniff::class);
    $services->set(UpperCaseConstantNameSniff::class);
    $services->set(UseDeclarationSniff::class);
    $services->set(ValidClassNameSniff::class);
    $services->set(ValidLogicalOperatorsSniff::class);
    $services->set(VisibilityRequiredFixer::class)
        ->call(
            'configure',
            [[
                'elements' => ['property', 'method', 'const'],
            ]]
        );
    $services->set(VoidReturnFixer::class);
    $services->set(YodaStyleFixer::class)
        ->call(
            'configure',
            [[
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
            ]]
        );

    $services->set(MultilineWhitespaceBeforeSemicolonsFixer::class)
        ->call(
            'configure',
            [[
                'strategy' => 'no_multi_line',
            ]]
        );

    $parameters = $ecsConfig->parameters();

    $parameters->set(
        'skip',
        [
            '**/TestEntity.php',
            'PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ClassDeclarationSniff.EndFileAfterCloseBrace' => null,
            PhpdocAlignFixer::class => null,
            PhpdocAnnotationWithoutDotFixer::class => null,
            PhpdocSeparationFixer::class => null,
            'SlevomatCodingStandard\Sniffs\Classes\TraitUseSpacingSniff.IncorrectLinesCountBeforeFirstUse' => null,
            PhpdocToReturnTypeFixer::class => null,
            PhpUnitInternalClassFixer::class => null,
            PhpUnitTestClassRequiresCoversFixer::class => null,
            IncrementStyleFixer::class => null,
        ]
    );
};
