<?php

namespace Tests\Tools\Stub\Elevator;

use App\API\Domain\Model\Elevator\Elevator;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

final class ElevatorStub
{
    public static function create(array $params = []): Elevator
    {
        $faker = Factory::create();

        $defaultParameters = [
            'uuid' => Uuid::fromString($faker->uuid)
        ];

        $parameters = array_merge($defaultParameters, $params);

        return Elevator::create(
            $parameters['uuid']
        );
    }

    public static function random(): Elevator
    {
        return self::create([]);
    }
}
