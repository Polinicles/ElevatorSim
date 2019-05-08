<?php

namespace App\API\Domain\Model\Elevator;

use Ramsey\Uuid\UuidInterface;

class ElevatorFactory
{
    public function create(UuidInterface $uuid): Elevator
    {
        return Elevator::create($uuid);
    }
}
