<?php

namespace App\User\Application\Service;

use App\Shared\Application\Response\ErrorResponse;
use App\Shared\Domain\Gateway\RandomUserApiGatewayInterface;
use App\User\Domain\Exceptions\RandomUserGatewayException;
use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Domain\Service\UserImporterServiceInterface;
use Psr\Log\LoggerInterface;

final class UserImporterService implements UserImporterServiceInterface
{

    public function __construct(
        private readonly RandomUserApiGatewayInterface $gateway,
        private readonly UserRepositoryInterface $repository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function handle(int $limit = self::LIMIT): ?ErrorResponse
    {
        try {
            $users = $this->gateway->fetchUser($limit);

            foreach ($users as $user) {
                $existingUser = $this->repository->findByEmail($user->getEmail());

                if ($existingUser !== null) {
                    $this->logger->info('User already exists', ['email' => $user->getEmail()]);
                }

                $newUser = new User(
                    id: $this->repository->findNextId(),
                    firstName: $user->getFirstName(),
                    lastName: $user->getLastName(),
                    email: $user->getEmail(),
                    username: $user->getUsername(),
                    password: md5($user->getPassword()),
                    gender: $user->getGender(),
                    country: $user->getCountry(),
                    city: $user->getCity(),
                    phone: $user->getPhone(),
                );
                $this->repository->save($newUser);

                $this->logger->info('User imported', ['email' => $user->getEmail()]);
            }
        } catch (RandomUserGatewayException $exception) {
            return ErrorResponse::fromError($exception->getMessage(), $exception->getCode());
        }

        return null;
    }
}
