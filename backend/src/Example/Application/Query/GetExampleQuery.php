<?php

declare(strict_types=1);

namespace App\Example\Application\Query;

use App\Example\Application\Dto\ExampleDto;
use Illuminate\Database\ConnectionInterface;
use stdClass;

final readonly class GetExampleQuery
{
    public function __construct(
        private ConnectionInterface $manager
    ) {
    }

    public function getById(int $id): ?ExampleDto
    {
        $builder = $this->manager
            ->table('examples')
            ->select(['name', 'comment'])
            ->where('id', $id);

        /** @var null|stdClass $result */
        $result = $builder->first();

        if ($result === null) {
            return null;
        }

        return new ExampleDto($id, $result->name, $result->comment);
    }
}
