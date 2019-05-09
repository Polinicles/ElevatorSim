<?php

namespace Tests\Tools\Stub\Call;

use App\API\Domain\Model\Call\Call;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

final class CallStub
{
    public static function create(array $params = []): Call
    {
        $faker = Factory::create();

        $defaultParameters = [
            'uuid' => Uuid::fromString($faker->uuid),
            'called_at' => new \DateTimeImmutable(),
            'origin' => random_int(0, 3),
            'destiny' => random_int(0, 3)
        ];

        $parameters = array_merge($defaultParameters, $params);

        return Call::create(
            $parameters['uuid'],
            $parameters['called_at'],
            $parameters['origin'],
            $parameters['destiny']
        );
    }

    public static function random(): Call
    {
        return self::create([]);
    }
}
