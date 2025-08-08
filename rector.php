<?php

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withPaths([
        __DIR__.'/src',
    ])
    ->withPhpSets(php84: true)
    // here we can define, what prepared sets of rules will be applied
    ->withComposerBased(symfony: true)
    ->withPreparedSets(deadCode: true, codeQuality: true, doctrineCodeQuality: true, symfonyCodeQuality: true)
    ->withAttributesSets(symfony: true, doctrine: true)
    ->withSets([
        LevelSetList::UP_TO_PHP_84,
    ])
    ->withSkip([
        StringClassNameToClassConstantRector::class => [
            __DIR__.'/src/DependencyInjection/Configuration.php',
        ],
    ])
;
