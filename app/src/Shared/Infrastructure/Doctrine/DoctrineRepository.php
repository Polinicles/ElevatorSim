<?php

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;

abstract class DoctrineRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function persist($entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }
}
