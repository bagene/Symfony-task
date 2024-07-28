<?php

declare(strict_types=1);

namespace App\Tests\Functional\User\Infrastructure\Controllers;

use App\Tests\FunctionalTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class UserControllerTest extends FunctionalTestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

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

    public function testGetUser(): void
    {
        $this->client->request(
            self::GET_METHOD,
            '/customers/' . $this->user->getId()
        );

        $response = $this->getJsonResponse();

        $this->assertResponseIsSuccessful();

        $this->assertMatchesPattern([
            'fullName' => '@string@',
            'email' => '@string@',
            'username' => '@string@',
            'gender' => '@string@',
            'country' => '@string@',
            'city' => '@string@',
            'phone' => '@string@',
        ], $response);
    }

    public function testGetUserNotFound(): void
    {
        $this->client->request(
            self::GET_METHOD,
            '/customers/' . Uuid::v4()
        );

        $response = $this->getJsonResponse();

        $this->assertResponseStatusCodeSame(404);

        $this->assertMatchesPattern([
            'message' => 'User not found',
            'code' => 404,
        ], $response);
    }

    public function testGetUsers(): void
    {
        $this->client->request(
            self::GET_METHOD,
            '/customers'
        );

        $response = $this->getJsonResponse();

        $this->assertResponseIsSuccessful();

        $this->assertMatchesPattern([
            '0' => [
                'fullName' => '@string@',
                'email' => '@string@',
                'country' => '@string@',
            ],
        ], $response);
    }
}
