<?php

declare(strict_types=1);

namespace App\Example\Application\Command;

use App\Example\Application\Dto\ExampleDto;
use Illuminate\Database\ConnectionInterface;
use JsonException;

final readonly class ExampleOutboxCommand
{
    public function __construct(
        private ConnectionInterface $manager,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function insert(ExampleDto $data): int
    {
        return $this->manager->table('example_outbox')
            ->insertGetId(
                [
                    'serialized_data' => json_encode($data, JSON_THROW_ON_ERROR),
                    'created' => date('Y-m-d'),
                    'updated' => date('Y-m-d'),
                ],
                'outbox_id'
            );
    }
}
