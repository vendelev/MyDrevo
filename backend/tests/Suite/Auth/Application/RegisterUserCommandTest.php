<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Application;

use App\Auth\Application\Command\RegisterUserCommand;
use App\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class RegisterUserCommandTest extends TestCase
{
    public function testRegisterUserCommandExecution(): void
    {
        $user = new User([
            'id' => 1,
            'login' => 'testuser',
            'password' => 'password',
            'firstName' => 'John',
            'middleName' => null,
            'lastName' => 'Smith',
            'email' => 'john@example.com',
            'userType' => 1,
            'active' => true,
            'createdAt' => 'now',
        ]);

        $command = $this->service(RegisterUserCommand::class);
        $command->handle($user);

        // Verify in DB
        $dbUser = DB::table('gen_user')->where('email', 'john@example.com')->first();
        self::assertNotNull($dbUser);
        self::assertEquals('testuser', $dbUser->login);
    }
}
