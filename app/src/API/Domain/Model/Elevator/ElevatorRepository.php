<?php

namespace App\API\Domain\Model\Elevator;

interface ElevatorRepository
{
    public function list(): array;

    public function save(Elevator $Elevator): void;
}
