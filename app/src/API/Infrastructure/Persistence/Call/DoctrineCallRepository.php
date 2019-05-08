<?php

namespace App\API\Infrastructure\Persistence\Call;

use App\API\Domain\Model\Call\Call;
use App\API\Domain\Model\Call\CallRepository;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;

class DoctrineCallRepository extends DoctrineRepository implements CallRepository
{
    public function list(): array
    {
        return $this->entityManager()->getRepository(Call::class)->findAll(); //TODO: improve this method
    }

    public function save(Call $call): void
    {
        $this->persist($call);
    }
}
