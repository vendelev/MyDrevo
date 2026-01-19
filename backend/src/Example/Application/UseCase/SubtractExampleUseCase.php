<?php

declare(strict_types=1);

namespace App\Example\Application\UseCase;

use App\Example\Application\Dto\Calculated;
use App\Example\Application\Responder\ExampleReportResponder;
use App\Example\Application\Service\ExampleCalcService;
use App\Example\Domain\ValueObject\SubtractNumbersVO;

final readonly class SubtractExampleUseCase
{
    public function __construct(
        private ExampleCalcService $service,
        private ExampleReportResponder $report
    ) {
    }

    public function subtractAndMakeReport(SubtractNumbersVO $numbers): string
    {
        $data = [
            new Calculated(
                $numbers->number1,
                $numbers->number2,
                $this->service->subtract($numbers->number1, $numbers->number2)
            ),
            new Calculated(
                $numbers->number2,
                $numbers->number1,
                $this->service->subtract($numbers->number2, $numbers->number1)
            ),
        ];

        return $this->report->render($data);
    }
}
