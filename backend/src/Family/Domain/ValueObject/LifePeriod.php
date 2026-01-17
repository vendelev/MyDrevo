<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

use App\Family\Domain\Exception\InvalidLifePeriodException;
use DateTimeImmutable;

final readonly class LifePeriod
{
    /**
     * @throws InvalidLifePeriodException
     */
    public function __construct(
        public ?DateTimeImmutable $birthDate = null,
        public ?DateTimeImmutable $deathDate = null
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidLifePeriodException
     */
    private function validate(): void
    {
        if (
            $this->birthDate instanceof \DateTimeImmutable
            && $this->deathDate instanceof \DateTimeImmutable
            && $this->birthDate > $this->deathDate
        ) {
            throw InvalidLifePeriodException::birthDateAfterDeathDate();
        }
    }
}
