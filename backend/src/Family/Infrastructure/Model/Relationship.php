<?php

declare(strict_types=1);

namespace App\Family\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $person_id
 * @property int $relative_id
 * @property string $type
 * @property string|null $metadata
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read \App\Family\Infrastructure\Model\FamilyMember $person
 * @property-read \App\Family\Infrastructure\Model\FamilyMember $relative
 */
class Relationship extends Model
{
    protected $table = 'family_relationships';

    protected $fillable = [
        'id',
        'person_id',
        'relative_id',
        'type',
        'metadata',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'person_id' => 'integer',
        'relative_id' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * @return BelongsTo<\App\Family\Infrastructure\Model\FamilyMember, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(\App\Family\Infrastructure\Model\FamilyMember::class, 'person_id');
    }

    /**
     * @return BelongsTo<\App\Family\Infrastructure\Model\FamilyMember, $this>
     */
    public function relative(): BelongsTo
    {
        return $this->belongsTo(\App\Family\Infrastructure\Model\FamilyMember::class, 'relative_id');
    }

    public $incrementing = true;

    protected $keyType = 'int';
}
