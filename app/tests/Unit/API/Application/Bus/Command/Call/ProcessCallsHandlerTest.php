<?php

namespace Tests\Unit\API\Application\Bus\Command\Call;

use App\API\Application\Bus\Command\Call\ProcessCalls;
use App\API\Application\Bus\Command\Call\ProcessCallsHandler;
use App\API\Application\Service\Call\Manager\CallManager;
use App\API\Domain\Model\Call\CallRepository;
use App\API\Domain\Model\Elevator\ElevatorRepository;
use PHPUnit\Framework\TestCase;
use Tests\Tools\Stub\Call\CallStub;
use Tests\Tools\Stub\Elevator\ElevatorStub;

class ProcessCallsHandlerTest extends TestCase
{
    public function test_build_valid_profile_handler()
    {
        /** @var CallRepository */
        $callRepository = $this->prophesize(CallRepository::class);
        /** @var ElevatorRepository */
        $elevatorRepository = $this->prophesize(ElevatorRepository::class);
        /** @var CallManager */
        $callManager = $this->prophesize(CallManager::class);

        $processCalls = ProcessCalls::fromArray([]);

        $call = CallStub::random();
        $calls = [$call];
        $elevator = ElevatorStub::random();
        $elevators = [$elevator];

        $callRepository->list()->shouldBeCalled()->willReturn($calls);
        $elevatorRepository->list()->shouldBeCalled()->willReturn($elevators);
        $callManager->manageCalls($calls, $elevators)->shouldBeCalled()->willReturn($calls);

        $processCallsHandler = new ProcessCallsHandler(
            $callRepository->reveal(),
            $elevatorRepository->reveal(),
            $callManager->reveal()
        );

        $processCallsHandler->handleProcessCalls($processCalls);
    }
}
