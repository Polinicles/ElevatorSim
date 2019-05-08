<?php

namespace App\API\Application\Bus\Command\Call;

use App\API\Domain\Model\Call\CallReadModel;
use App\API\Domain\Model\Elevator\ElevatorReadModel;
use Broadway\CommandHandling\SimpleCommandHandler;

class ProcessCallsHandler extends SimpleCommandHandler
{
    private $callReadModel;

    private $elevatorReadModel;

    private $reportBuilder;

    public function __construct(
        CallReadModel $callReadModel,
        ElevatorReadModel $elevatorReadModel
    ) {
        $this->callReadModel = $callReadModel;
        $this->elevatorReadModel = $elevatorReadModel;
//        $this->reportBuilder = $reportBuilder;
    }

    /**
     * @param ProcessCalls $processCalls
     * @throws \Doctrine\DBAL\DBALException
     */
    public function handleProcessCalls(ProcessCalls $processCalls)
    {
        $availableCalls = $this->callReadModel->list();
        $availableElevators = $this->elevatorReadModel->list();

        dump($availableCalls); dump($availableElevators);
    }
}
