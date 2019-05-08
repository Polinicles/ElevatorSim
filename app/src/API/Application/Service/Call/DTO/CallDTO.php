<?php

namespace App\API\Application\Service\Call\DTO;

use App\Shared\Application\Service\DTO;

class CallDTO implements DTO
{
    /** @var string */
    private $uuid;

    /** @var \DateTimeImmutable */
    private $calledAt;

    /** @var int */
    private $origin;

    /** @var int */
    private $destiny;

    public function __construct(string $uuid, \DateTimeImmutable $calledAt, int $origin, int $destiny)
    {
        $this->uuid = $uuid;
        $this->calledAt = $calledAt;
        $this->origin = $origin;
        $this->destiny = $destiny;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function calledAt(): \DateTimeImmutable
    {
        return $this->calledAt;
    }

    public function origin(): int
    {
        return $this->origin;
    }

    public function destiny(): int
    {
        return $this->destiny;
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid(),
            'called_at' => $this->calledAt(),
            'origin' => $this->origin(),
            'destiny' => $this->destiny()
        ];
    }
}
