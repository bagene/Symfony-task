<?php

declare(strict_types=1);

namespace App\User\Domain\Repositories;

use App\User\Domain\Model\User;

interface UserRepositoryInterface
{
    public function findNextId(): string;

    public function save(User $user): void;

    public function find(string $id): ?User;

    public function findByEmail(string $email): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;
}
