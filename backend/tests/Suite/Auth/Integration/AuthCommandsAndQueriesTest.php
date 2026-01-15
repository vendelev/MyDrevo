<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Integration;

use App\Auth\Application\Command\RegisterUserCommand;
use App\Auth\Application\Query\GetUserByEmailQuery;
use App\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class AuthCommandsAndQueriesTest extends TestCase
{
    /**
     * @throws \DateMalformedStringException
     */
    public function testSaveAndFindUser(): void
    {
        // Arrange
        $userData = [
            'id' => 1,
            'login' => 'testuser',
            'password' => 'hashedpassword',
            'fname' => 'John',
            'sname' => 'Doe',
            'surname' => 'Smith',
            'email' => 'john@example.com',
            'user_type' => 1,
            'active' => 1,
            'create_date' => '2023-01-01 00:00:00',
        ];

        DB::table('gen_user')->insert($userData);

        // Act: Find user by email
        $getUserQuery = $this->service(GetUserByEmailQuery::class);
        $foundUser = $getUserQuery->handle('john@example.com');

        // Assert
        self::assertNotNull($foundUser);
        self::assertEquals('testuser', $foundUser->getLogin());
        self::assertEquals('john@example.com', $foundUser->getEmail());
        self::assertEquals('John', $foundUser->getFirstName());
        self::assertEquals('Doe', $foundUser->getMiddleName());
        self::assertEquals('Smith', $foundUser->getLastName());
        self::assertTrue($foundUser->isActive());
        self::assertEquals(1, $foundUser->getUserType());

        // Test save via Command
        $user = new User(
            id: 2,
            login: 'newuser',
            password: 'newpassword',
            firstName: 'Jane',
            middleName: null,
            lastName: 'Doe',
            email: 'jane@example.com',
            userType: 1,
            active: true,
            createdAt: new \DateTimeImmutable()
        );

        $registerCommand = $this->service(RegisterUserCommand::class);
        $registerCommand->handle($user);

        // Verify data in DB
        $dbUser = DB::table('gen_user')->where('email', 'jane@example.com')->first();
        self::assertNotNull($dbUser);
        self::assertEquals('newuser', $dbUser->login);
        self::assertEquals('newpassword', $dbUser->password);
        self::assertEquals('Jane', $dbUser->fname);
        self::assertNull($dbUser->sname);
        self::assertEquals('Doe', $dbUser->surname);
        self::assertEquals('jane@example.com', $dbUser->email);
        self::assertEquals(1, $dbUser->user_type);
        self::assertEquals(1, $dbUser->active);
    }
}
