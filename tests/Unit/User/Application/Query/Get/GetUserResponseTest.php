<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Application\Query\Get;

use App\Tests\UnitTestCase;
use App\User\Application\Query\Get\GetUserResponse;

final class GetUserResponseTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $response = new GetUserResponse(
            fullName: 'John Doe',
            email: 'test@example.org',
            username: 'John',
            gender: 'male',
            country: 'USA',
            city: 'city',
            phone: '123456789',
        );

        $this->assertEquals('John Doe', $response->getFullName());
        $this->assertEquals('test@example.org', $response->getEmail());
        $this->assertEquals('John', $response->getUsername());
        $this->assertSame('male', $response->getGender());
        $this->assertEquals('USA', $response->getCountry());
        $this->assertEquals('city', $response->getCity());
        $this->assertEquals('123456789', $response->getPhone());
    }
}
