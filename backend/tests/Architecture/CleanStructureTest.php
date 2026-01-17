<?php

declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\BuildStep;
use PHPat\Test\PHPat;

final readonly class CleanStructureTest
{
    /**
     * Проверим структуру папок в Application
     */
    public function testApplicationFolder(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Command[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Factory[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Responder[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Query[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\UseCase[\\\]*\.*/', true),
            )
            ->shouldBeNamed('/.+Application.+/', true)
            ->because('Этот класс должен находится в слое Application');
    }

    /**
     * Проверим обязательность Final
     */
    public function testIsFinal(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Application[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Domain\\\\Entity[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Domain\\\\ValueObject[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Infrastructure[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Presentation[\\\]*\.*/', true),
            )
            ->shouldBeFinal()
            ->because('Класс должен быть Final');
    }

    /**
     * Проверим обязательность Readonly для Application
     */
    public function testIsReadonly(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Application[\\\]*\.*/', true),
            )
            ->excluding(Selector::isEnum())
            ->shouldBeReadonly()
            ->because('Класс должен быть Readonly');
    }

    /**
     * Проверим структуру папок в Domain
     */
    public function testDomainFolder(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Event[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Exception[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Entity[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Request[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Response[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Validation[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\ValueObject[\\\]*\.*/', true),
            )
            ->shouldBeNamed('/.+Domain.+/', true)
            ->because('Этот класс должен находится в слое Domain');
    }

    /**
     * Проверим интерфейсы созданы в Domain
     */
    public function testInterfaceInDomain(): BuildStep
    {
        return Phpat::rule()
            ->classes(Selector::isInterface())
            ->shouldBeNamed('/.+Domain.+/', true)
            ->because('Все Interface должны находится в слое Domain');
    }

    /**
     * Проверим структуру папок в Presentation
     */
    public function testPresentationFolder(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Config[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Console[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Http[\\\]*\.*/', true),
                Selector::inNamespace('/^App.*\\\\Listener[\\\]*\.*/', true),
            )
            ->shouldBeNamed('/.+Presentation.+/', true)
            ->because('Этот класс должен находится в слое Presentation');
    }

    /**
     * Проверим структуру папок в Infrastructure
     */
    public function testInfrastructureFolder(): BuildStep
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('/^App.*\\\\Adapter[\\\]*\.*/', true),
            )
            ->shouldBeNamed('/.+Infrastructure.+/', true)
            ->because('Этот класс должен находится в слое Infrastructure');
    }
}
