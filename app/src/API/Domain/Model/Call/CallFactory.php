<?php

namespace App\API\Domain\Model\Call;

use Ramsey\Uuid\UuidInterface;

final class CallFactory
{
    public function create(
        UuidInterface $uuid,
        \DateTimeImmutable $calledAt,
        int $origin,
        int $destiny
    ): Call {
        return Call::create($uuid, $calledAt, $origin, $destiny);
    }
}
