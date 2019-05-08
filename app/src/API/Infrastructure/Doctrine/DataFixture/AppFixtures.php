<?php

namespace App\API\Infrastructure\Doctrine\DataFixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Tests\Tools\Stub\Elevator\ElevatorStub;
use Tests\Tools\Stub\Sequence\SequenceStub;

final class AppFixtures extends Fixture
{
    const ELEVATORS = 3;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $sequence1 = SequenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 5,
            'start' => new \DateTimeImmutable('09:00'),
            'end' => new \DateTimeImmutable('11:00'),
            'from' => json_encode([0]),
            'to' => 2
        ]);

        $sequence2 = SequenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 10,
            'start' => new \DateTimeImmutable('09:00'),
            'end' => new \DateTimeImmutable('11:00'),
            'from' => json_encode([0]),
            'to' => 1
        ]);

        $sequence3 = SequenceStub::create([
            'uuid' => Uuid::fromString($faker->uuid),
            'ocurrence' => 4,
            'start' => new \DateTimeImmutable('14:00'),
            'end' => new \DateTimeImmutable('15:00'),
            'from' => json_encode([1,2,3]),
            'to' => 0
        ]);

        $sequence4 = SequenceStub::create([
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

        $manager->persist($sequence1);
        $manager->persist($sequence2);
        $manager->persist($sequence3);
        $manager->persist($sequence4);
        $manager->flush();
    }
}
