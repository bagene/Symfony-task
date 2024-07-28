<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Application\Service;

use App\Tests\IntegrationTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Domain\Service\UserImporterServiceInterface;

final class UserImporterServiceTest extends IntegrationTestCase
{
    private UserImporterServiceInterface $service;
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var UserImporterServiceInterface $service */
        $service = self::getContainer()->get(UserImporterServiceInterface::class);
        $this->service = $service;

        /** @var UserRepositoryInterface $repository */
        $repository = self::getContainer()->get(UserRepositoryInterface::class);
        $this->repository = $repository;
    }

    public function testHandleReturnSuccess(): void
    {
        $response = $this->service->handle();

        $this->assertNull($response);

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
