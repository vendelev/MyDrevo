<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    protected $fillable = [
        'id',
        'login',
        'password',
        'firstName',
        'middleName',
        'lastName',
        'createdAt',
        'active',
        'email',
        'userType',
    ];

    protected $table = 'gen_user';

    public const CREATED_AT = 'create_date';

    public const UPDATED_AT = null;

    private readonly int $id;

    private readonly string $login;

    private readonly string $password;

    private readonly string $fname;

    private readonly ?string $sname;

    private readonly string $surname;

    private readonly string $email;

    private readonly int $userType;

    private readonly bool $active;

    private readonly string $createDate;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->id = $attributes['id'] ?? 0;
        $this->login = $attributes['login'] ?? '';
        $this->password = $attributes['password'] ?? '';
        $this->fname = $attributes['firstName'] ?? '';
        $this->sname = $attributes['middleName'] ?? null;
        $this->surname = $attributes['lastName'] ?? '';
        $this->email = $attributes['email'] ?? '';
        $this->userType = $attributes['userType'] ?? 1;
        $this->active = $attributes['active'] ?? true;
        $this->createDate = $attributes['createdAt'] ?? 'now';
    }

    // Required by Laravel's Authenticatable
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getFname(): string
    {
        return $this->fname;
    }

    public function getSname(): ?string
    {
        return $this->sname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserType(): int
    {
        return $this->userType;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreateDate(): string
    {
        return $this->createDate;
    }
}
