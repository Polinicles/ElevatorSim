<?php

namespace App\API\Infrastructure\Doctrine\DataFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Tests\Tools\Stub\Elevator\ElevatorStub;
use Tests\Tools\Stub\Secuence\SecuenceStub;

final class AppFixtures extends Fixture
{
    const ELEVATORS = 3;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $secuence1 = SecuenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 5,
            'start' => new \DateTimeImmutable('09:00'),
            'end' => new \DateTimeImmutable('11:00'),
            'from' => json_encode([0]),
            'to' => 2
        ]);

        $secuence2 = SecuenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 10,
            'start' => new \DateTimeImmutable('09:00'),
            'end' => new \DateTimeImmutable('11:00'),
            'from' => json_encode([0]),
            'to' => 1
        ]);

        $secuence3 = SecuenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 4,
            'start' => new \DateTimeImmutable('14:00'),
            'end' => new \DateTimeImmutable('15:00'),
            'from' => json_encode([1,2,3]),
            'to' => 0
        ]);

        $secuence4 = SecuenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 7,
            'start' => new \DateTimeImmutable('15:00'),
            'end' => new \DateTimeImmutable('16:00'),
            'from' => json_encode([2,3]),
            'to' => 0
        ]);

        for ($i = 0; $i < self::ELEVATORS; $i++) {
            $elevator = ElevatorStub::random();
            $manager->persist($elevator);
        }

        $manager->persist($secuence1);
        $manager->persist($secuence2);
        $manager->persist($secuence3);
        $manager->persist($secuence4);
        $manager->flush();
    }
}
