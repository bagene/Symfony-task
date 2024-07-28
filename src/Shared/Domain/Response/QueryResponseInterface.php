<?php

declare(strict_types=1);

namespace App\Shared\Domain\Response;

interface QueryResponseInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
