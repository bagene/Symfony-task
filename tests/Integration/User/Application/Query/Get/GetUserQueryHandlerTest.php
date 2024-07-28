<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Application\Query\Get;

use App\Shared\Application\Response\ErrorResponse;
use App\Tests\IntegrationTestCase;
use App\User\Application\Query\Get\GetUserQuery;
use App\User\Application\Query\Get\GetUserQueryHandler;
use App\User\Application\Query\Get\GetUserResponse;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class GetUserQueryHandlerTest extends IntegrationTestCase
{
    private GetUserQueryHandler $handler;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GetUserQueryHandler $handler */
        $handler = self::getContainer()->get(GetUserQueryHandler::class);
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

        $this->user = $user;
    }

    public function testInvokeReturnSuccess(): void
    {
        $response = ($this->handler)(new GetUserQuery($this->user->getId()));

        $this->assertInstanceOf(GetUserResponse::class, $response);

        $this->assertSame('John Doe', $response->getFullName());
        $this->assertSame('test@example.org', $response->getEmail());
        $this->assertSame('john', $response->getUsername());
        $this->assertSame('male', $response->getGender());
        $this->assertSame('US', $response->getCountry());
        $this->assertSame('New York', $response->getCity());
        $this->assertSame('1234567890', $response->getPhone());
    }

    public function testInvokeReturnNotFound(): void
    {
        $response = ($this->handler)(new GetUserQuery((string) Uuid::v4()));

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->assertSame('User not found', $response->getMessage());
        $this->assertSame(404, $response->getCode());
    }
}
