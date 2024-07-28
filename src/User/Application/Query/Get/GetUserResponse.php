<?php

declare(strict_types=1);

namespace App\User\Application\Query\Get;

use App\Shared\Application\Traits\ToArray;
use App\Shared\Domain\Response\QueryResponseInterface;
use App\User\Domain\Model\User;

final class GetUserResponse implements QueryResponseInterface
{
    use ToArray;
    public function __construct(
        private readonly string $fullName,
        private readonly string $email,
        private readonly string $username,
        private readonly string $gender,
        private readonly string $country,
        private readonly string $city,
        private readonly string $phone,
    ) {
    }

    public static function fromUserModel(User $user): self
    {
        return new self(
            fullName: "{$user->getFirstName()} {$user->getLastName()}",
            email: $user->getEmail(),
            username: $user->getUsername(),
            gender: $user->getGender(),
            country: $user->getCountry(),
            city: $user->getCity(),
            phone: $user->getPhone(),
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
