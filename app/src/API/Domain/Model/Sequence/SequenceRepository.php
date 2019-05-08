<?php

namespace App\API\Domain\Model\Sequence;

interface SequenceRepository
{
    public function list(): array;
}
