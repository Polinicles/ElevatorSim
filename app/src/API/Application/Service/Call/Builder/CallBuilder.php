<?php

namespace App\API\Application\Service\Call\Builder;

use App\API\Application\Service\Sequence\DTO\SequenceDTO;
use App\API\Domain\Model\Call\Call;
use App\API\Domain\Model\Call\CallFactory;
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

        /** @var SequenceDTO $sequence */
        foreach ($sequences as $sequence) {
            $initialTime = $sequence->start();

            while ($initialTime <= $sequence->end()) {

                foreach ($sequence->origin() as $elevatorCall) {
                    $call = $this->callFactory->create(
                        Uuid::uuid4(),
                        $initialTime,
                        $elevatorCall,
                        $sequence->destiny()
                    );
                }

            }
            $initialTime->add(new \DateInterval('PT' . $sequence->ocurrence(). 'M'));
        }

        return $calls;
    }

    private function createCall()
    {

    }
}
