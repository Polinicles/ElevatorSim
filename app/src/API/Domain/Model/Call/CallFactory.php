<?php

namespace App\API\Domain\Model\Call;

use Ramsey\Uuid\UuidInterface;

class CallFactory
{
    public function create(
        UuidInterface $uuid,
        \DateTimeImmutable $time,
        int $origin,
        int $destiny
    ): Call {
        return Call::create($uuid, $time, $origin, $destiny);
    }
}
