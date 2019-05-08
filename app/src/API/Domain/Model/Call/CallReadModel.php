<?php

namespace App\API\Domain\Model\Call;

use App\API\Application\Service\Call\DTO\CallDTO;

interface CallReadModel
{
    /**
     * @return CallDTO[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function list(): array;
}
