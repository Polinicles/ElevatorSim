<?php

namespace Tests\Tools\Stub\Sequence;

use App\API\Domain\Model\Sequence\Sequence;

final class SequenceStub
{
    public static function create(array $params = []): Sequence
    {
        return Sequence::create(
            $params['uuid'],
            $params['ocurrence'],
            $params['start'],
            $params['end'],
            $params['from'],
            $params['to']
        );
    }
}
