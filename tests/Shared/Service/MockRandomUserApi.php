<?php

declare(strict_types=1);

namespace App\Tests\Shared\Service;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\Response\MockResponse;

final class MockRandomUserApi
{
    private const USERS_URL = '/(randomuser.me)*.*$/';
    private string $responseDir;

    public function __construct(string $projectDir)
    {
        $this->responseDir = implode(
            DIRECTORY_SEPARATOR,
            [$projectDir, 'tests', 'Shared', 'File']
        ) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function __invoke(string $method, string $uri, array $options): ResponseInterface
    {
        /** @var string $defaultBody */
        $defaultBody = json_encode([sprintf('Method not found: %s: %s', $method, $uri)]);

        if (preg_match(self::USERS_URL, $uri)) {
            return $this->getUserResponse($uri);
        }

        return new MockResponse($defaultBody, [
            'http_code' => 500,
        ]);
    }

    private function getUserResponse(string $uri): ResponseInterface
    {
        if (str_contains($uri, 'results=0')) {
            return new MockResponse('', ['http_code' => 500]);
        }

        /** @var string $body */
        $body = file_get_contents($this->responseDir . 'random_user_api.json');

        return new MockResponse($body, ['http_code' => 200]);
    }
}
