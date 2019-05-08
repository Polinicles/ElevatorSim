<?php

namespace App\API\Domain\Model\Secuence;

use App\API\Application\Service\Sequence\DTO\SequenceDTO;

interface SequenceReadModel
{
    /**
     * @return SequenceDTO[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function list(): array;
}
