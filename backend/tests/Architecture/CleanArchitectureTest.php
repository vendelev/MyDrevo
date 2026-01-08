<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\BuildStep;
use PHPat\Test\PHPat;

final readonly class CleanArchitectureTest
{
    /**
     * Проверим зависимость между Domain и другими слоями
     */
    public function testDomainLayer(): BuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('/^Parser.*\\\\Domain\\\\.*/', true))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('/^Parser.*\\\\Application\\\\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Presentation\\\\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Infrastructure\\\\.*/', true),
            )
            ->because('Domain может использовать только Domain (и свой и чужой)');
    }

    /**
     * Проверим зависимость между Application и другими слоями
     */
    public function testApplicationLayer(): BuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('/^Parser.*\\\\Application\\\\.*/', true))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('/^Parser.*\\\\Presentation\\\\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Infrastructure\\\\.*/', true),
            )
            ->because('Application может использовать Domain (только свой)');
    }

    /**
     * Проверим зависимость между Infrastructure и другими слоями
     */
    public function testInfrastructureLayer(): BuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('/^Parser.*\\\\Infrastructure\\\\.*/', true))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('/^Parser.*\\\\Presentation\\\\.*/', true),
            )
            ->because('Infrastructure может использовать только Application и Domain (и свой и чужой)');
    }
}
