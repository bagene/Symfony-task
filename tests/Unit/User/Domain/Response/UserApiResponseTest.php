<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Domain\Response;

use App\Tests\UnitTestCase;
use App\User\Domain\Response\UserApiResponse;

final class UserApiResponseTest extends UnitTestCase
{
    public function testGettersFromResponse(): void
    {
        $response = UserApiResponse::fromResponse([
            'login' => [
                'uuid' => 'uuid',
                'username' => 'username',
                'password' => 'password'
            ],
            'name' => [
                'first' => 'first',
                'last' => 'last'
            ],
            'email' => 'email',
            'location' => [
                'country' => 'country',
                'city' => 'city'
            ],
            'phone' => 'phone',
            'gender' => 'male',
        ]);

        $this->assertSame('uuid', $response->getId());
        $this->assertSame('first', $response->getFirstName());
        $this->assertSame('last', $response->getLastName());
        $this->assertSame('email', $response->getEmail());
        $this->assertSame('country', $response->getCountry());
        $this->assertSame('city', $response->getCity());
        $this->assertSame('phone', $response->getPhone());
        $this->assertSame('male' , $response->getGender());
        $this->assertSame('password', $response->getPassword());
    }
}
