<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Infrastructure\Repositories;

use App\Tests\IntegrationTestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;

final class DoctrineUserRepositoryTest extends IntegrationTestCase
{
    private UserRepositoryInterface $repository;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var UserRepositoryInterface $repository */
        $repository = self::getContainer()->get(UserRepositoryInterface::class);
        $this->repository = $repository;

        $user = new User(
            id: $this->repository->findNextId(),
            firstName: 'John',
            lastName: 'Doe',
            email: 'test@example.org',
            username: 'john',
            password: md5('password'),
            gender: 'male',
            country: 'US',
            city: 'New York',
            phone: '1234567890',
        );
        $this->repository->save($user);

        $this->user = $user;
    }

    public function testFindNextId(): void
    {
        $id = $this->repository->findNextId();

        $this->assertIsString($id);
        $this->assertMatchesPattern('@uuid@', $id);
    }

    public function testFind(): void
    {
        /** @var User $user */
        $user = $this->repository->find($this->user->getId());

        $this->assertInstanceOf(User::class, $user);

        $this->assertSame($this->user->getId(), $user->getId());
        $this->assertSame($this->user->getFirstName(), $user->getFirstName());
        $this->assertSame($this->user->getLastName(), $user->getLastName());
        $this->assertSame($this->user->getEmail(), $user->getEmail());
        $this->assertSame($this->user->getUsername(), $user->getUsername());
        $this->assertSame($this->user->getPassword(), $user->getPassword());
        $this->assertSame($this->user->getGender(), $user->getGender());
        $this->assertSame($this->user->getCountry(), $user->getCountry());
        $this->assertSame($this->user->getCity(), $user->getCity());
        $this->assertSame($this->user->getPhone(), $user->getPhone());
    }

    public function testSave(): void
    {
        $user = new User(
            id: $this->repository->findNextId(),
            firstName: 'Jane',
            lastName: 'Doe',
            email: 'jane@example.org',
            username: 'jane',
            password: md5('password'),
            gender: 'female',
            country: 'US',
            city: 'New York',
            phone: '1234567890',
        );

        $this->repository->save($user);

        /** @var User $newUser */
        $newUser = $this->repository->find($user->getId());

        $this->assertSame($user->getId(), $newUser->getId());
        $this->assertSame($user->getFirstName(), $newUser->getFirstName());
        $this->assertSame($user->getLastName(), $newUser->getLastName());
        $this->assertSame($user->getEmail(), $newUser->getEmail());
        $this->assertSame($user->getUsername(), $newUser->getUsername());
        $this->assertSame($user->getPassword(), $newUser->getPassword());
        $this->assertSame($user->getGender(), $newUser->getGender());
        $this->assertSame($user->getCountry(), $newUser->getCountry());
        $this->assertSame($user->getCity(), $newUser->getCity());
        $this->assertSame($user->getPhone(), $newUser->getPhone());
    }

}
