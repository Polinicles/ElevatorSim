<?php

namespace Tests\Unit\API\Application\Bus\Command\Call;

use App\API\Application\Bus\Command\Call\GenerateCalls;
use App\API\Application\Bus\Command\Call\GenerateCallsHandler;
use App\API\Application\Service\Call\Builder\CallBuilder;
use App\API\Domain\Model\Call\CallRepository;
use App\API\Domain\Model\Sequence\SequenceRepository;
use PHPUnit\Framework\TestCase;
use Tests\Tools\Stub\Call\CallStub;
use Tests\Tools\Stub\Sequence\SequenceStub;

class GenerateCallsHandlerTest extends TestCase
{

    public function test_build_valid_profile_handler()
    {
        /** @var SequenceRepository */
        $sequenceRepository = $this->prophesize(SequenceRepository::class);
        /** @var CallBuilder */
        $callBuilder = $this->prophesize(CallBuilder::class);
        /** @var CallRepository */
        $callRepository = $this->prophesize(CallRepository::class);

        $generateCalls = GenerateCalls::fromArray([]);
        $sequence = SequenceStub::random();
        $sequences = [$sequence];

        $call = CallStub::random();

        $sequenceRepository->list()->shouldBeCalled()->willReturn($sequences);
        $callBuilder->buildFromSequences($sequences)->shouldBeCalled()->willReturn([$call]);

        $generateCallsHandler = new GenerateCallsHandler(
            $sequenceRepository->reveal(),
            $callBuilder->reveal(),
            $callRepository->reveal()
        );

        $generateCallsHandler->handleGenerateCalls($generateCalls);
    }
}
