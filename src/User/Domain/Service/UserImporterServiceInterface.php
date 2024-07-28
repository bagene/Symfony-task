<?php

namespace App\User\Domain\Service;

use App\Shared\Application\Response\ErrorResponse;

interface UserImporterServiceInterface
{
    const LIMIT = 100;
    public function handle(int $limit = self::LIMIT): ?ErrorResponse;
}
