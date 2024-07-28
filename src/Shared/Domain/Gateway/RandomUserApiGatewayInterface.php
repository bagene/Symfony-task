<?php

declare(strict_types=1);

namespace App\Shared\Domain\Gateway;

use App\User\Domain\Exceptions\RandomUserGatewayException;
use App\User\Domain\Response\UserApiResponse;

interface RandomUserApiGatewayInterface
{
    const DEFAULT_LIMIT = 100;
    /**
     * @return UserApiResponse[]
     * @throws RandomUserGatewayException
     */
    public function fetchUser(int $limit = self::DEFAULT_LIMIT): array;
}
