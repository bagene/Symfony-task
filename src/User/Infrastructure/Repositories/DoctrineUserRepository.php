<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repositories;

use App\User\Domain\Model\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Uid\Uuid;

final readonly class DoctrineUserRepository implements UserRepositoryInterface
{
    /** @var ObjectRepository<User> */
    private ObjectRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function findNextId(string $id = null): string
    {
        return $id ?? (string) Uuid::v4();
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function find(string $id): ?User
    {
        /** @var ?User $user */
        $user = $this->repository->find($id);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var ?User $user */
        $user = $this->repository->findOneBy(['email' => $email]);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        /** @var User[] $result */
        $result = $this->repository->findAll();

        return $result;
    }
}
