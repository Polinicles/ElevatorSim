<?php

namespace App\API\Domain\Model\Call;

use Ramsey\Uuid\UuidInterface;

final class Call
{
    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var \DateTimeImmutable */
    private $time;

    /** @var int */
    private $origin;

    /** @var int */
    private $destiny;

    public static function create(UuidInterface $uuid, \DateTimeImmutable $time, int $origin, int $destiny): Call
    {
        return new self($uuid, $time, $origin, $destiny);
    }

    private function __construct(UuidInterface $uuid, \DateTimeImmutable $time, int $origin, int $destiny)
    {
        $this->uuid = $uuid;
        $this->time = $time;
        $this->origin = $origin;
        $this->destiny = $destiny;
    }

}
