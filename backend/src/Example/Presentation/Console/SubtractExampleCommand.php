<?php

declare(strict_types=1);

namespace App\Example\Presentation\Console;

use App\Example\Application\UseCase\SubtractExampleUseCase;
use App\Example\Domain\Exception\InvalidSubtractNumbersException;
use App\Example\Domain\ValueObject\SubtractNumbersVO;
use Illuminate\Console\Command;

final class SubtractExampleCommand extends Command
{
    protected $signature = 'example:subtract {first : Первое число} {second : Второе число}';

    protected $description = 'Вычитает два числа и выводит результат';

    public function __construct(
        private readonly SubtractExampleUseCase $useCase
    ) {
        parent::__construct();
    }

    /**
     * @throws InvalidSubtractNumbersException
     */
    public function handle(): int
    {
        $numbers = new SubtractNumbersVO(
            (float)$this->argument('first'),
            (float)$this->argument('second')
        );

        $result = $this->useCase->subtractAndMakeReport($numbers);

        $this->info("Результат вычитания:\n");
        $this->info($result);

        return self::SUCCESS;
    }
}
