<?php

namespace App\API\Application\Bus\Command\Call;

use App\API\Application\Service\Call\Builder\CallBuilder;
use App\API\Domain\Model\Call\CallRepository;
use App\API\Domain\Model\Sequence\SequenceRepository;
use Broadway\CommandHandling\SimpleCommandHandler;

class GenerateCallsHandler extends SimpleCommandHandler
{
    /** @var SequenceRepository */
    private $SequenceRepository;

    /** @var CallBuilder */
    private $callBuilder;

    /** @var CallRepository */
    private $callRepository;

    public function __construct(
        SequenceRepository $SequenceRepository,
        CallBuilder $callBuilder,
        CallRepository $callRepository
    ) {
        $this->SequenceRepository = $SequenceRepository;
        $this->callBuilder = $callBuilder;
        $this->callRepository = $callRepository;
    }

    /**
     * @param GenerateCalls $generateCalls
     * @throws \Exception
     */
    public function handleGenerateCalls(GenerateCalls $generateCalls)
    {
        $availableSequences = $this->SequenceRepository->list();
        $calls = $this->callBuilder->buildFromSequences($availableSequences);

        foreach ($calls as $call) {
            $this->callRepository->save($call);
        }
    }
}
