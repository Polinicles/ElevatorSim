<?php

namespace App\API\Application\Service\Call\Manager;

use App\API\Application\Service\Report\Builder\ReportBuilder;
use App\API\Domain\Model\Call\Call;
use App\API\Domain\Model\Elevator\Elevator;

final class CallManager
{
    private $reportBuilder;

    public function __construct(ReportBuilder $reportBuilder)
    {
        $this->reportBuilder = $reportBuilder;
    }

    /**
     * @param Call[]
     * @param Elevator[]
     * @return Call[]
     */
    public function manageCalls(array &$calls, array &$elevators): array
    {
        /** @var Call */
        foreach ($calls as $call) {
            $sameTimeCalls = $this->getSameTimeCalls($calls, $call->calledAt());
            $this->assignElevators($sameTimeCalls, $elevators);
            $this->freeElevators($elevators);

            foreach ($sameTimeCalls as $handledCall) {
                unset($calls[array_search($handledCall, $calls)]);
            }
        }

        return $calls;
    }

    /**
     * @param Call[]
     * @param \DateTimeImmutable $time
     * @return Call[]
     */
    private function getSameTimeCalls(array $calls, \DateTimeImmutable $time): array
    {
        $callsAtSameTime = [];

        foreach ($calls as $call) {
            if($call->calledAt() == $time) {
                array_push($callsAtSameTime, $call);
            }
        }

        return $callsAtSameTime;
    }

    /**
     * @param Call[]
     * @param Elevator[]
     * @return void
     */
    private function assignElevators(array &$calls, array &$elevators): void
    {
        foreach ($calls as $call) {
            $availableElevators = $this->getAvailableElevator($elevators);dump('available elevators: '.sizeof($elevators));
            if(null !== $availableElevators) {
                $closestElevator = $this->getClosestElevator($availableElevators, $call->origin());
                $closestElevator->take();
                $closestElevator->increaseFloorTrips(abs($closestElevator->currentFloor() - $call->destiny()));
                $closestElevator->moveToFloor($call->destiny());
                $call->completedBy($closestElevator);
//                echo('T: '.$call->calledAt()->format('H:s').' ID '.$closestElevator->id().' CF '.$closestElevator->currentFloor().' FT '.$closestElevator->floorsTravelled().' \r\n');
            } else {
                echo('no available elevator for that call :/');
            }
        }
    }

    /**
     * @param array $elevators
     * @return array
     */
    private function getAvailableElevator(array &$elevators): ?array
    {
        if(sizeof($elevators) === 0) {
            return null;
        }

        if ($this->checkIfOnlyOneElevator($elevators)) {
            return $elevators[0];
        }

        $freeElevators = [];

        foreach ($elevators as $elevator) {
            if ($elevator->isEmpty()) {
                array_push($freeElevators, $elevator);
            }
        }

        return $freeElevators;
    }

    /**
     * @param array $elevators
     * @param int $callOrigin
     * @return Elevator
     */
    private function getClosestElevator(array &$elevators, int $callOrigin): Elevator
    {
        if ($this->checkIfOnlyOneElevator($elevators)) {
            return $elevators[0];
        }

        $currentLowestDistance = 0;
        $closestElevator = $elevators[0];

        foreach ($elevators as $elevator) {
            $distance = abs($elevator->currentFloor() - $callOrigin);
            if ($distance <= $currentLowestDistance) {
                $closestElevator = $elevator;
                $currentLowestDistance = $distance;
            }
        }

        return $closestElevator;
    }

    /**
     * @param array $elevators
     * @return bool
     */
    private function checkIfOnlyOneElevator(array $elevators): bool
    {
        return sizeof($elevators) === 1;
    }

    /**
     * @param Elevator[]
     * @return void
     */
    private function freeElevators(array &$elevators): void
    {
        foreach ($elevators as $elevator) {
            $elevator->free();
        }
    }
}
