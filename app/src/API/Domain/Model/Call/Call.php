<?php

namespace App\API\Domain\Model\Call;

use App\API\Domain\Model\Elevator\Elevator;
use Ramsey\Uuid\UuidInterface;

final class Call
{
    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var \DateTimeImmutable */
    private $calledAt;

    /** @var int */
    private $origin;

    /** @var int */
    private $destiny;

    /** @var Elevator */
    private $elevator;

    public function id(): ?int
    {
        return $this->id;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function calledAt(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->calledAt->format('H:i'));
    }

    public function origin(): int
    {
        return $this->origin;
    }

    public function destiny(): int
    {
        return $this->destiny;
    }

    public function elevator(): Elevator
    {
        return $this->elevator;
    }

    public function completedBy(Elevator $elevator): void
    {
        $this->elevator = $elevator;
    }

    public static function create(UuidInterface $uuid, \DateTimeImmutable $calledAt, int $origin, int $destiny): Call
    {
        return new self($uuid, $calledAt, $origin, $destiny);
    }

    private function __construct(UuidInterface $uuid, \DateTimeImmutable $calledAt, int $origin, int $destiny)
    {
        $this->uuid = $uuid;
        $this->calledAt = $calledAt;
        $this->origin = $origin;
        $this->destiny = $destiny;
        $this->elevator = null;
    }
}
