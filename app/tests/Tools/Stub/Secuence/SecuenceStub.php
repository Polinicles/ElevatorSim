<?php

namespace Tests\Tools\Stub\Secuence;

use App\API\Domain\Model\Secuence\Secuence;

final class SecuenceStub
{
    public static function create(array $params = []): Secuence
    {
        return Secuence::create(
            $params['uuid'],
            $params['ocurrence'],
            $params['start'],
            $params['end'],
            $params['from'],
            $params['to']
        );
    }
}
