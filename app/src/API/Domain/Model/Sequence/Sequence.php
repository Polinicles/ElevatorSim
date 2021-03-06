<?php

namespace App\API\Domain\Model\Sequence;

use Ramsey\Uuid\UuidInterface;

final class Sequence
{
    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var int */
    private $ocurrence;

    /** @var \DateTimeImmutable */
    private $start;

    /** @var \DateTimeImmutable */
    private $end;

    /** @var string */
    private $origin;

    /** @var int */
    private $destiny;

    public function id(): ?int
    {
        return $this->id;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function ocurrence(): int
    {
        return $this->ocurrence;
    }

    public function start(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->start->format('H:i'));
    }

    public function end(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->end->format('H:i'));
    }

    public function origin(): array
    {
        return json_decode($this->origin);
    }

    public function destiny(): int
    {
        return $this->destiny;
    }

    public static function create(
        UuidInterface $uuid,
        int $ocurrence,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        string $origin,
        int $destiny
    ): Sequence {
        return new self($uuid, $ocurrence, $start, $end, $origin, $destiny);
    }

    private function __construct(
        UuidInterface $uuid,
        int $ocurrence,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        string $origin,
        int $destiny
    ) {
        $this->uuid = $uuid;
        $this->ocurrence = $ocurrence;
        $this->start = $start;
        $this->end = $end;
        $this->origin = $origin;
        $this->destiny = $destiny;
    }
}
