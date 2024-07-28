<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Gateway;

use App\Shared\Domain\Gateway\RandomUserApiGatewayInterface;
use App\User\Domain\Exceptions\RandomUserGatewayException;
use App\User\Domain\Response\UserApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class RandomUserApiGateway implements RandomUserApiGatewayInterface
{
    private const BASE_URL = 'https://randomuser.me/api/';
    private const COUNTRY = 'au';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @return never-return
     */
    private function handleException(\Throwable $exception = null): void
    {
        throw new RandomUserGatewayException('Failed to fetch user data from RandomUser API', 0, $exception);
    }

    /**
     * @inheritDoc
     */
    public function fetchUser(int $limit = self::DEFAULT_LIMIT): array
    {
        try {
            $response = $this->client->request('GET', self::BASE_URL, [
                'query' => [
                    'results' => $limit,
                    'nat' => self::COUNTRY,
                ],
            ]);

            if (200 !== $response->getStatusCode()) {
                $this->handleException();
            }

            return array_map(
                fn ($user) => UserApiResponse::fromResponse($user),
                $response->toArray()['results'],
            );
        } catch (
            ClientExceptionInterface
            | DecodingExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | TransportExceptionInterface $exception
        ) {
            $this->logger->error($exception->getMessage(), [
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ]);
            $this->handleException($exception);
        }
    }
}
