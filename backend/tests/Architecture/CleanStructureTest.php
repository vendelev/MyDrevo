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
                Selector::inNamespace('/^Parser.*\\\\Command[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Factory[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Responder[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Query[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\UseCase[\\\]*\.*/', true),
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
                Selector::inNamespace('/^Parser.*\\\\Application[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Infrastructure[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Presentation[\\\]*\.*/', true),
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
                Selector::inNamespace('/^Parser.*\\\\Application[\\\]*\.*/', true),
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
                Selector::inNamespace('/^Parser.*\\\\Event[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Exception[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Entity[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Request[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Response[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Validation[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\ValueObject[\\\]*\.*/', true),
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
                Selector::inNamespace('/^Parser.*\\\\Config[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Console[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Http[\\\]*\.*/', true),
                Selector::inNamespace('/^Parser.*\\\\Listener[\\\]*\.*/', true),
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
                Selector::inNamespace('/^Parser.*\\\\Adapter[\\\]*\.*/', true),
            )
            ->shouldBeNamed('/.+Infrastructure.+/', true)
            ->because('Этот класс должен находится в слое Infrastructure');
    }
}
