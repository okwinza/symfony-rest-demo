<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Group;
use App\Model\GroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class GroupRepository
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
        $this->repository = $entityManager->getRepository(Group::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findOneById(int $id): ?GroupInterface
    {
        return $this->repository->find($id);
    }

    public function save(GroupInterface $group): void
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }
}