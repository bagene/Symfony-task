<?php

declare(strict_types=1);

namespace App\User\Domain\Response;

final class UserApiResponse
{
    private function __construct(
        private readonly string $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly string $username,
        private readonly string $password,
        private readonly string $gender,
        private readonly string $country,
        private readonly string $city,
        private readonly string $phone,
    ) {
    }

    /**
     * @param array{
     *  login: array{uuid: string, username: string, password: string},
     *  name: array{first: string, last: string},
     *  email: string,
     *  location: array{country: string, city: string},
     *  phone: string,
     *  gender: string
     * } $result
     */
    public static function fromResponse(array $result): self
    {
        return new self(
            id: $result['login']['uuid'],
            firstName: $result['name']['first'],
            lastName: $result['name']['last'],
            email: $result['email'],
            username: $result['login']['username'],
            password: $result['login']['password'],
            gender: $result['gender'],
            country: $result['location']['country'],
            city: $result['location']['city'],
            phone: $result['phone'],
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
