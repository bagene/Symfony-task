<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Infrastructure\Console\Commands;

use App\Tests\IntegrationTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Infrastructure\Console\Commands\UserImportCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

final class UserImportCommandTest extends IntegrationTestCase
{
    private UserImportCommand $command;
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var UserImportCommand $command */
        $command = self::getContainer()->get(UserImportCommand::class);
        $this->command = $command;

        /** @var UserRepositoryInterface $repository */
        $repository = self::getContainer()->get(UserRepositoryInterface::class);
        $this->repository = $repository;
    }

    public function testUserImportCommand(): void
    {
        $response = $this->command->run(new ArrayInput([]), new NullOutput());

        $this->assertEquals(0, $response);

        // Imported User Info can be found in the ff directory
        // Mock File: tests/Shared/File/random_user_api.json
        $user = $this->repository->findByEmail('jennie.nichols@example.com');

        $this->assertInstanceOf(User::class, $user);

        $this->assertSame('Jennie', $user->getFirstName());
        $this->assertSame('Nichols', $user->getLastName());
        $this->assertSame('jennie.nichols@example.com', $user->getEmail());
        $this->assertSame('female', $user->getGender());
        $this->assertSame('United States', $user->getCountry());
        $this->assertSame('Billings', $user->getCity());
        $this->assertSame('(272) 790-0888', $user->getPhone());
    }
}
