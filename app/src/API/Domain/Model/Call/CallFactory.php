<?php

namespace App\API\Domain\Model\Call;

use Ramsey\Uuid\UuidInterface;

class CallFactory
{
    public function create(
        UuidInterface $uuid,
        \DateTimeImmutable $time,
        int $from,
        int $to
    ): Call {
        return Call::create($uuid, $time, $from, $to);
    }
}
