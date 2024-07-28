<?php

declare(strict_types=1);

namespace App\User\Application\Query\Get;

use App\Shared\Application\Response\ErrorResponse;
use App\User\Domain\Repositories\UserRepositoryInterface;

final class GetUserQueryHandler
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(GetUserQuery $query): GetUserResponse|ErrorResponse
    {
        $user = $this->repository->find($query->getId());

        if ($user === null) {
            return ErrorResponse::fromError('User not found', 404);
        }

        return GetUserResponse::fromUserModel($user);
    }
}
