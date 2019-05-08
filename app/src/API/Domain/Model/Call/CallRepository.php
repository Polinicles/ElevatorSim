<?php

namespace App\API\Domain\Model\Call;

interface CallRepository
{
    public function save(Call $call): void;
}
