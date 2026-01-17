<?php

declare(strict_types=1);

namespace App\Modules\Family\Domain\ValueObject;

use App\Modules\Family\Domain\Exception\InvalidLifePeriodException;
use DateTimeImmutable;

class LifePeriod
{
    /**
     * @throws InvalidLifePeriodException
     */
    public function __construct(
        private readonly ?DateTimeImmutable $birthDate = null,
        private readonly ?DateTimeImmutable $deathDate = null
    ) {
        $this->validate();
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function getDeathDate(): ?DateTimeImmutable
    {
        return $this->deathDate;
    }

    /**
     * @throws InvalidLifePeriodException
     */
    private function validate(): void
    {
        if ($this->birthDate && $this->deathDate && $this->birthDate > $this->deathDate) {
            throw InvalidLifePeriodException::birthDateAfterDeathDate();
        }
    }
}