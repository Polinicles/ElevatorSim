<?php

namespace App\API\Domain\Model\Event;

use App\API\Domain\Model\Call\Call;
use App\API\Domain\Model\Elevator\Elevator;
use Ramsey\Uuid\UuidInterface;

final class Event
{
    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var Elevator */
    private $elevator;

    /** @var Call */
    private $call;

    public function create(UuidInterface $uuid, Elevator $elevator, Call $call): Event
    {
        return new self($uuid, $elevator, $call);
    }

    private function __construct(UuidInterface $uuid, Elevator $elevator, Call $call)
    {
        $this->uuid = $uuid;
        $this->elevator = $elevator;
        $this->call = $call;
    }
}
