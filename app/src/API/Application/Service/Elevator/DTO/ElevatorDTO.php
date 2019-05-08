<?php

namespace App\API\Application\Service\Elevator\DTO;

use App\Shared\Application\Service\DTO;

class ElevatorDTO implements DTO
{
    /** @var string */
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid()
        ];
    }
}
