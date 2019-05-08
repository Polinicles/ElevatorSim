<?php

namespace App\API\Application\Bus\Command\Call;

use App\API\Domain\Model\Call\CallRepository;
use App\API\Domain\Model\Elevator\ElevatorRepository;
use Broadway\CommandHandling\SimpleCommandHandler;

class ProcessCallsHandler extends SimpleCommandHandler
{
    private $callRepository;

    private $elevatorRepository;

    private $callManager;

    public function __construct(
        CallRepository $callRepository,
        ElevatorRepository $elevatorRepository
    ) {
        $this->callRepository = $callRepository;
        $this->elevatorRepository = $elevatorRepository;
//        $this->reportBuilder = $reportBuilder;
    }

    /**
     * @param ProcessCalls $processCalls
     * @throws \Doctrine\DBAL\DBALException
     */
    public function handleProcessCalls(ProcessCalls $processCalls)
    {
        $availableCalls = $this->callRepository->list();
        $availableElevators = $this->elevatorRepository->list();


    }
}
