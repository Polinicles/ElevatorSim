<?php

namespace App\API\Application\Service\Sequence\DTO;

use App\Shared\Application\Service\DTO;

class SequenceDTO implements DTO
{
    /** @var int */
    private $ocurrence;

    /** @var \DateTimeImmutable */
    private $start;

    /** @var \DateTimeImmutable */
    private $end;

    /** @var array */
    private $origin;

    /** @var int */
    private $destiny;

    public function __construct(
        int $ocurrence,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        array $origin,
        int $destiny
    ) {
        $this->ocurrence = $ocurrence;
        $this->start = $start;
        $this->end = $end;
        $this->origin = $origin;
        $this->destiny = $destiny;
    }

    public function ocurrence(): int
    {
        return $this->ocurrence;
    }

    public function start(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function end(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function origin(): array
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
            'ocurrence' => $this->ocurrence(),
            'start' => $this->start(),
            'end' => $this->end(),
            'origin' => $this->origin(),
            'destiny' => $this->destiny()
        ];
    }
}
