<?php

declare(strict_types=1);

namespace App\Shared\Application\Response;

use App\Shared\Application\Traits\ToArray;

final class ErrorResponse
{
    use ToArray;
    private const DEFAULT_CODE = 500;

    private function __construct(
        private readonly string $message,
        private readonly int $code,
    ) {
    }

    public static function fromError(
        string $message = '',
        int $code = self::DEFAULT_CODE,
    ): self {
        return new self($message, $code);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
