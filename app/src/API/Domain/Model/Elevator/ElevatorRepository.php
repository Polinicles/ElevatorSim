<?php

namespace App\API\Domain\Model\Elevator;

interface ElevatorRepository
{
    public function save(Elevator $Elevator): void;
}
