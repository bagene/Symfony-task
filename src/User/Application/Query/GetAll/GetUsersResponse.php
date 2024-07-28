<?php

declare(strict_types=1);

namespace App\User\Application\Query\GetAll;

use App\Shared\Application\Traits\ToArray;
use App\Shared\Domain\Response\QueryResponseInterface;
use App\User\Domain\Model\User;

final class GetUsersResponse implements QueryResponseInterface
{
    use ToArray;
    public function __construct(
        private readonly string $fullName,
        private readonly string $email,
        private readonly string $country,
    ) {
    }

    public static function fromUserModel(User $user): self
    {
        return new self(
            fullName: "{$user->getFirstName()} {$user->getLastName()}",
            email: $user->getEmail(),
            country: $user->getCountry(),
        );
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
