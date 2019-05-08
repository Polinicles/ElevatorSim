<?php

namespace App\API\Infrastructure\Persistence\Elevator;

use App\API\Domain\Model\Elevator\Elevator;
use App\API\Domain\Model\Elevator\ElevatorRepository;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;

class DoctrineElevatorRepository extends DoctrineRepository implements ElevatorRepository
{
    public function list(): array
    {
        return $this->entityManager()->getRepository(Elevator::class)->findAll(); //TODO: improve this method
    }

    public function save(Elevator $elevator): void
    {
        $this->persist($elevator);
    }
}
