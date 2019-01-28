<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\User;
use App\Model\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class UserRepository
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findOneById(int $id): ?UserInterface
    {
        return $this->repository->find($id);
    }

    public function save(UserInterface $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}