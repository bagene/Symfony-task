<?php

declare(strict_types=1);

namespace App\User\Application\Query\Get;

final class GetUserQuery
{
    public function __construct(private readonly string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
