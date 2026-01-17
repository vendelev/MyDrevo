<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

use App\Family\Domain\Exception\InvalidLifePeriodException;
use DateTimeImmutable;

class LifePeriod
{
    /**
     * @throws InvalidLifePeriodException
     */
    public function __construct(
        public readonly ?DateTimeImmutable $birthDate = null,
        public readonly ?DateTimeImmutable $deathDate = null
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
