<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Domain\Model;

use App\Tests\UnitTestCase;
use App\User\Domain\Model\User;
use Symfony\Component\Uid\Uuid;

final class UserTest extends UnitTestCase
{
    private function createUser(): User
    {
        return new User(
            id: (string) Uuid::v4(),
            firstName: 'John',
            lastName: 'Doe',
            email: 'test@example.org',
            username: 'john',
            password: 'password',
            gender: 'male',
            country: 'USA',
            city: 'New York',
            phone: '1234567890'
        );
    }

    public function testGetters(): void
    {
        $user = $this->createUser();

        $this->assertSame('John', $user->getFirstName());
        $this->assertSame('Doe', $user->getLastName());
        $this->assertSame('test@example.org', $user->getEmail());
        $this->assertSame('john', $user->getUsername());
        $this->assertSame('password', $user->getPassword());
        $this->assertSame('male', $user->getGender());
        $this->assertSame('USA', $user->getCountry());
        $this->assertSame('New York', $user->getCity());
        $this->assertSame('1234567890', $user->getPhone());
    }

    public function testSetters(): void
    {
        $user = $this->createUser();

        $user->setFirstName('Jane');
        $user->setLastName('Smith');
        $user->setEmail('jane@example.org');
        $user->setUsername('jane');
        $user->setPassword('new-password');
        $user->setGender('female');
        $user->setCountry('UK');
        $user->setCity('London');
        $user->setPhone('0987654321');

        $this->assertSame('Jane', $user->getFirstName());
        $this->assertSame('Smith', $user->getLastName());
        $this->assertSame('jane@example.org', $user->getEmail());
        $this->assertSame('jane', $user->getUsername());
        $this->assertSame('new-password', $user->getPassword());
        $this->assertSame('female', $user->getGender());
        $this->assertSame('UK', $user->getCountry());
        $this->assertSame('London', $user->getCity());
        $this->assertSame('0987654321', $user->getPhone());
    }
}
