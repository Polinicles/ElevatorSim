<?php

namespace App\API\Application\Service\Call\Builder;

use App\API\Domain\Model\Call\Call;
use App\API\Domain\Model\Call\CallFactory;
use App\API\Domain\Model\Sequence\Sequence;
use Ramsey\Uuid\Uuid;

final class CallBuilder
{
    private $callFactory;

    public function __construct(CallFactory $callFactory)
    {
        $this->callFactory = $callFactory;
    }

    /**
     * @param array $sequences
     * @return Call[]
     * @throws \Exception
     */
    public function buildFromSequences(array $sequences): array
    {
        $calls = [];

        /** @var Sequence $sequence */
        foreach ($sequences as $sequence) {
            $calls = array_merge(
                array_values($calls),
                array_values($this->generateCallsFromSequence($sequence->start(), $sequence))
            );
        }
        return $calls;
    }

    /**
     * @param \DateTimeImmutable $start
     * @param Sequence $sequence
     * @return Call[]
     * @throws \Exception
     */
    private function generateCallsFromSequence(\DateTimeImmutable $start, Sequence $sequence): array
    {
        $newSequenceCalls = [];

        while ($start <= $sequence->end()) {
            $sequenceSameTimeCalls = $this->generateSameTimeCalls(
                $sequence->origin(),
                $start,
                $sequence->destiny()
            );

            $newSequenceCalls = array_merge(
                array_values($newSequenceCalls),
                array_values($sequenceSameTimeCalls)
            );
            $start = $this->increaseTimeStep($start, $sequence->ocurrence());
        }

        return $newSequenceCalls;
    }

    /**
     * @param array $elevatorCalls
     * @param \DateTimeImmutable $callTime
     * @param int $callDestiny
     * @return Call[]
     * @throws \Exception
     */
    private function generateSameTimeCalls(
        array $elevatorCalls,
        \DateTimeImmutable $callTime,
        int $callDestiny
    ): array {
        $callsFromManyOrigins = [];

        foreach ($elevatorCalls as $callOrigin) {
            $newCall = $this->createCall($callTime, $callOrigin, $callDestiny);
            array_push($callsFromManyOrigins, $newCall);
        }

        return $callsFromManyOrigins;
    }

    /**
     * @param \DateTimeImmutable $time
     * @param int $step
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    private function increaseTimeStep(\DateTimeImmutable $time, int $step): \DateTimeImmutable
    {
        return $time->add(new \DateInterval('PT'.$step.'M'));
    }

    /**
     * @param \DateTimeImmutable $callTime
     * @param int $origin
     * @param int $destiny
     * @return Call
     * @throws \Exception
     */
    private function createCall(\DateTimeImmutable $callTime, int $origin, int $destiny): Call
    {
        return $this->callFactory->create(Uuid::uuid4(), $callTime, $origin, $destiny);
    }
}
