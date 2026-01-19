<?php

declare(strict_types=1);

namespace App\Example\Domain\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $outbox_id
 * @property string $serialized_data
 * @property DateTimeInterface $created
 * @property DateTimeInterface $updated
 *
 * @mixin Builder<ExampleOutbox>
 */
final class ExampleOutbox extends Model
{
    protected $table = 'example_outbox';

    protected $primaryKey = 'outbox_id';

    protected $fillable = [
        'outbox_id',
        'serialized_data',
        'created',
        'updated',
    ];

    protected $casts = [
        'outbox_id' => 'integer',
        'created' => 'date',
        'updated' => 'date',
    ];
}
