<?php

declare(strict_types=1);

namespace App\Family\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string $gender
 * @property string|null $birth_date
 * @property string|null $death_date
 * @property string|null $biography
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read \App\Auth\Domain\Entity\User $user
 */
final class FamilyMember extends Model
{
    protected $table = 'family_members';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birth_date',
        'death_date',
        'biography',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public $incrementing = true;

    protected $keyType = 'int';

    /**
     * @return BelongsTo<\App\Auth\Domain\Entity\User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<\App\Auth\Domain\Entity\User, $this> */
        return $this->belongsTo(\App\Auth\Domain\Entity\User::class, 'user_id');
    }
}
