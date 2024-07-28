<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $id;

    public function __construct(
        string $id,
        #[ORM\Column(type: 'string', length: 255)]
        private string $firstName,
        #[ORM\Column(type: 'string', length: 255)]
        private string $lastName,
        #[ORM\Column(type: 'string', length: 255)]
        private string $email,
        #[ORM\Column(type: 'string', length: 255)]
        private string $username,
        #[ORM\Column(type: 'string', length: 255)]
        private string $password,
        #[ORM\Column(type: 'string', length: 255)]
        private string $gender,
        #[ORM\Column(type: 'string', length: 255)]
        private string $country,
        #[ORM\Column(type: 'string', length: 255)]
        private string $city,
        #[ORM\Column(type: 'string', length: 255)]
        private string $phone
    ) {
        $this->id = Uuid::fromString($id);
    }

    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}
