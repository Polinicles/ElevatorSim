<?php

namespace App\API\Domain\Model\Elevator;

interface ElevatorReadModel
{
    /**
     * @return Elevator[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function list(): array;
}
