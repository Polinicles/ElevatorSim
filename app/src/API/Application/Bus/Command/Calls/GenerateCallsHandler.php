<?php

namespace App\API\Application\Bus\Command\Call;

use App\API\Application\Bus\Command\Calls\GenerateCalls;
use App\API\Application\Service\Call\Builder\CallBuilder;
use App\API\Domain\Model\Sequence\SequenceReadModel;

class GenerateCallsHandler
{
    /** @var SequenceReadModel */
    private $sequenceReadModel;

    /** @var CallBuilder */
    private $callBuilder;

    /** @var CallRepository */
    private $CallRepository;

    public function __construct(
        SequenceReadModel $sequenceReadModel,
        CallBuilder $CallBuilder,
        CallRepository $CallRepository
    ) {
        $this->sequenceReadModel = $sequenceReadModel;
        $this->callBuilder = $CallBuilder;
        $this->CallRepository = $CallRepository;
    }

    /**
     * @param GenerateCalls $generateCalls
     * @throws \Doctrine\DBAL\DBALException
     */
    public function handleGenerateCalls(GenerateCalls $generateCalls)
    {
        $availableSequences = $this->sequenceReadModel->list();
        $calls = $this->callBuilder->buildFromSequences($availableSequences);

        foreach ($calls as $call) {
            $this->CallRepository->save($call);
        }
    }
}
