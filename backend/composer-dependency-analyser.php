<?php

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return new Configuration()
    ->addPathsToScan(['config'], false)
    ->ignoreErrorsOnExtension('ext-pdo', [ErrorType::UNUSED_DEPENDENCY])
    ->ignoreErrorsOnPackage('symfony/http-foundation', [ErrorType::SHADOW_DEPENDENCY])
    ;
