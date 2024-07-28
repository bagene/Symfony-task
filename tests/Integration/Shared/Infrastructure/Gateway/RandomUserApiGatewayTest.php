<?php

declare(strict_types=1);

namespace App\Tests\Integration\Shared\Infrastructure\Gateway;

use App\Shared\Domain\Gateway\RandomUserApiGatewayInterface;
use App\Tests\IntegrationTestCase;
use App\User\Domain\Exceptions\RandomUserGatewayException;
use App\User\Domain\Response\UserApiResponse;

final class RandomUserApiGatewayTest extends IntegrationTestCase
{
    private RandomUserApiGatewayInterface $gateway;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var RandomUserApiGatewayInterface $gateway */
        $gateway = self::getContainer()->get(RandomUserApiGatewayInterface::class);
        $this->gateway = $gateway;
    }

    public function testFetchUserReturnSuccess(): void
    {
        $response = $this->gateway->fetchUser();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertInstanceOf(UserApiResponse::class, $response[0]);
    }

    public function testFetchUserReturnError(): void
    {
        $this->expectException(RandomUserGatewayException::class);
        $this->expectExceptionMessage('Failed to fetch user data from RandomUser API');

        $this->gateway->fetchUser(0);
    }
}
