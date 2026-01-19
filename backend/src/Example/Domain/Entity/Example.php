<?php

declare(strict_types=1);

namespace App\Example\Domain\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property null|string $comment
 * @property int $user_id
 * @property DateTimeInterface $created_at
 *
 * @mixin Builder<Example>
 */
final class Example extends Model
{
    protected $table = 'examples';

    protected $fillable = [
        'id',
        'name',
        'comment',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];
}
