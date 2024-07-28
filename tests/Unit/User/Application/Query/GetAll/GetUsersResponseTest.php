<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Application\Query\GetAll;

use App\Tests\UnitTestCase;
use App\User\Application\Query\GetAll\GetUsersResponse;

final class GetUsersResponseTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $response = new GetUsersResponse(
            fullName: 'John Doe',
            email: 'test@example.org',
            country: 'US',
        );

        $this->assertSame('John Doe', $response->getFullName());
        $this->assertSame('test@example.org', $response->getEmail());
        $this->assertSame('US', $response->getCountry());
    }
}
