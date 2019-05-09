<?php

namespace App\API\Domain\Model\Elevator;

use Ramsey\Uuid\UuidInterface;

final class ElevatorFactory
{
    public function create(UuidInterface $uuid): Elevator
    {
        return Elevator::create($uuid);
    }
}
