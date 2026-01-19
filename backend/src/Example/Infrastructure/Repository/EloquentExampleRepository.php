<?php

declare(strict_types=1);

namespace App\Example\Infrastructure\Repository;

use App\Example\Domain\Dto\CreateExampleDto;
use App\Example\Domain\Entity\Example as ExampleModel;
use App\Example\Domain\ExampleRepositoryInterface;

final class EloquentExampleRepository implements ExampleRepositoryInterface
{
    public function store(CreateExampleDto $example): int
    {
        $model = new ExampleModel();
        $model->user_id = $example->userId;
        $model->created_at = $example->createdAt;
        $model->name = $example->name;
        $model->comment = $example->comment;

        $model->save();

        return $model->id;
    }
}
