<?php

namespace App\API\Domain\Model\Elevator;

use Ramsey\Uuid\UuidInterface;

final class Elevator
{
    const STATUS_AVAILABLE = 'available';

    const STATUS_OCUPIED = 'ocupied';

    const INITIAL_FLOOR = 0;

    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var string */
    private $status;

    /** @var int */
    private $currentFloor;

    public function create(UuidInterface $uuid): Elevator
    {
        return new self($uuid);
    }

    public function changeStatus(string $status): void
    {

    }

    public function moveToFloor(int $floor): void
    {
        $this->currentFloor = $floor;
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
        $this->status = self::STATUS_AVAILABLE;
        $this->currentFloor = self::INITIAL_FLOOR;
    }
}
