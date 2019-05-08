<?php

namespace App\API\Application\Bus\Command\Call;

use App\API\Application\Service\Call\Manager\CallManager;
use App\API\Domain\Model\Call\CallRepository;
use App\API\Domain\Model\Elevator\Elevator;
use App\API\Domain\Model\Elevator\ElevatorRepository;
use Broadway\CommandHandling\SimpleCommandHandler;

class ProcessCallsHandler extends SimpleCommandHandler
{
    /** @var CallRepository */
    private $callRepository;

    /** @var ElevatorRepository */
    private $elevatorRepository;

    /** @var CallManager */
    private $callManager;

    public function __construct(
        CallRepository $callRepository,
        ElevatorRepository $elevatorRepository,
        CallManager $callManager
    ) {
        $this->callRepository = $callRepository;
        $this->elevatorRepository = $elevatorRepository;
        $this->callManager = $callManager;
    }

    /**
     * @param ProcessCalls $processCalls
     * @throws \Doctrine\DBAL\DBALException
     */
    public function handleProcessCalls(ProcessCalls $processCalls)
    {
        $availableCalls = $this->callRepository->list();
        $availableElevators = $this->elevatorRepository->list();

        /** @var Elevator $elevator */
        foreach ($availableElevators as $elevator) {
            $elevator->reset();
        }

        $calls = $this->callManager->manageCalls($availableCalls, $availableElevators);

//        foreach ($calls as $call) {
//            $this->callRepository->save($call);
//        }
    }
}
