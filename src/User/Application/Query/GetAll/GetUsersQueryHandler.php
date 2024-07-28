<?php

declare(strict_types=1);

namespace App\User\Application\Query\GetAll;

use App\User\Domain\Repositories\UserRepositoryInterface;

final class GetUsersQueryHandler
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    /**
     * @return GetUsersResponse[]
     */
    public function __invoke(GetUsersQuery $query): array
    {
        return array_map(
            fn ($user) => GetUsersResponse::fromUserModel($user),
            $this->repository->getAll(),
        );
    }
}
