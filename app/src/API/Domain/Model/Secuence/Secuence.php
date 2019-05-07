<?php

namespace App\API\Domain\Model\Secuence;

use Ramsey\Uuid\UuidInterface;

final class Secuence
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

    public static function create(
        UuidInterface $uuid,
        int $ocurrence,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        string $origin,
        int $destiny
    ): Secuence {
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
