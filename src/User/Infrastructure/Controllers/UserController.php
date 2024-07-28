<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Controllers;

use App\Shared\Application\Response\ErrorResponse;
use App\Shared\Domain\Response\QueryResponseInterface;
use App\User\Application\Query\Get\GetUserQuery;
use App\User\Application\Query\GetAll\GetUsersQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus,
    ) {
        $this->messageBus = $messageBus;
    }

    /**
     * This method is responsible for serializing the query response
     * This can be refactored to a mapper class or trait
     * For this test, since there are only 2 routes, I opted to keep it here
     *
     * @param array<int, QueryResponseInterface>|QueryResponseInterface|ErrorResponse $response
     */
    private function serializeQueryResponse(array|QueryResponseInterface|ErrorResponse $response): JsonResponse
    {
        $status = 200;
        if ($response instanceof ErrorResponse) {
            $status = $response->getCode();
        }

        if (is_array($response)){
            return JsonResponse::fromJsonString(
                json_encode(
                    array_map(fn ($res) => $res->toArray(), $response)
                ) ?: '[]',
                $status
            );
        }

        return JsonResponse::fromJsonString(
            json_encode($response->toArray()) ?: '{}',
            $status
        );
    }

    #[Route('/customers/{id}', name: 'get_customer', methods: ['GET'])]
    public function get(string $id): JsonResponse
    {
        return $this->serializeQueryResponse(
            $this->handle(new GetUserQuery($id))
        );
    }

    #[Route('/customers', name: 'get_customers', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return $this->serializeQueryResponse(
            $this->handle(new GetUsersQuery())
        );
    }
}
