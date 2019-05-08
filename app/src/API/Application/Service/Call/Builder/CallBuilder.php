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
            $initialTime = $sequence->start();

            while ($initialTime <= $sequence->end()) {

                foreach ($sequence->origin() as $elevatorCall) {
                    $newCall = $this->callFactory->create(
                        Uuid::uuid4(),
                        $initialTime,
                        $elevatorCall,
                        $sequence->destiny()
                    );
                    array_push($calls, $newCall);
                }

                $initialTime = $this->increaseTimeStep($initialTime, $sequence->ocurrence());
            }
        }
        return $calls;
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

    //TODO: refactor this
}
