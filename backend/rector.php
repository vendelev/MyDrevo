<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withParallel()
    ->withCache(__DIR__ . '/storage/temp/rector')
    ->withPhpSets(php85: true)
    ->withPhpVersion(PhpVersion::PHP_85)
    ->withComposerBased(phpunit: true)
    ->withSets([
        SetList::DEAD_CODE,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::RECTOR_PRESET,
        SetList::INSTANCEOF,
        SetList::EARLY_RETURN,
        LaravelSetList::LARAVEL_120
    ])
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
        RemoveUnusedPublicMethodParameterRector::class,
        EncapsedStringsToSprintfRector::class,
        RemoveUselessParamTagRector::class,
        CatchExceptionNameMatchingTypeRector::class
    ]);
