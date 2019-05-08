<?php

namespace App\API\Domain\Model\Call;

interface CallRepository
{
    public function list(): array;

    public function save(Call $call): void;
}
