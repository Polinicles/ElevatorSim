<?php

namespace App\API\Infrastructure\Persistence\Sequence;

use App\API\Domain\Model\Sequence\Sequence;
use App\API\Domain\Model\Sequence\SequenceRepository;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;

class DoctrineSequenceRepository extends DoctrineRepository implements SequenceRepository
{
    public function list(): array
    {
        return $this->repository(Sequence::class)->findAll();
    }
}
