<?php

namespace App\API\Application\Bus\Command\Call;

use App\Shared\Application\Bus\Command\Command;

final class GenerateCalls implements Command
{
    private function __construct()
    {
    }

    public static function fromArray(array $data): Command
    {
        return new self();
    }
}
