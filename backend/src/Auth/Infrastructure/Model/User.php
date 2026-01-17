<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $fname
 * @property string|null $sname
 * @property string $surname
 * @property string $email
 * @property string $create_date
 * @property int $user_type
 * @property int|null $active
 */
final class User extends Authenticatable
{
    protected $table = 'gen_user';

    protected $fillable = [
        'id',
        'login',
        'password',
        'fname',
        'sname',
        'surname',
        'email',
        'create_date',
        'user_type',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_type' => 'integer',
        'active' => 'integer',
    ];

    public $timestamps = false;

    public $incrementing = true;

    protected $keyType = 'int';
}
