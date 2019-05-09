<?php

namespace Tests\Tools\Stub\Sequence;

use App\API\Domain\Model\Sequence\Sequence;
use Ramsey\Uuid\Uuid;

final class SequenceStub
{
    public static function create(array $params = []): Sequence
    {
        $defaultParameters = [
            'uuid' => Uuid::uuid4(),
            'ocurrence' => random_int(1, 5),
            'start' => new \DateTimeImmutable(),
            'end' => new \DateTimeImmutable(),
            'origin' => random_int(0, 3),
            'destiny' => random_int(0, 3)
        ];

        $parameters = array_merge($defaultParameters, $params);

        return Sequence::create(
            $parameters['uuid'],
            $parameters['ocurrence'],
            $parameters['start'],
            $parameters['end'],
            $parameters['origin'],
            $parameters['destiny']
        );
    }

    public static function random(): Sequence
    {
        return self::create([]);
    }
}
