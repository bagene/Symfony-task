<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Application\Query\GetAll;

use App\Tests\IntegrationTestCase;
use App\User\Application\Query\GetAll\GetUsersQuery;
use App\User\Application\Query\GetAll\GetUsersQueryHandler;
use App\User\Application\Query\GetAll\GetUsersResponse;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class GetUsersQueryHandlerTest extends IntegrationTestCase
{
    private GetUsersQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GetUsersQueryHandler $handler */
        $handler = self::getContainer()->get(GetUsersQueryHandler::class);
        $this->handler = $handler;

        /** @var UserRepositoryInterface $repository */
        $repository = self::getContainer()->get(UserRepositoryInterface::class);

        $user = new User(
            id: (string) Uuid::v4(),
            firstName: 'John',
            lastName: 'Doe',
            email: 'test@example.org',
            username: 'john',
            password: 'password',
            gender: 'male',
            country: 'US',
            city: 'New York',
            phone: '1234567890',
        );
        $repository->save($user);
    }

    public function testInvokeReturnSuccess(): void
    {
        $response = ($this->handler)(new GetUsersQuery());

        $this->assertIsArray($response);

        $this->assertInstanceOf(GetUsersResponse::class, $response[0]);
        $this->assertSame('John Doe', $response[0]->getFullName());
        $this->assertSame('test@example.org', $response[0]->getEmail());
        $this->assertSame('US', $response[0]->getCountry());
    }
}
