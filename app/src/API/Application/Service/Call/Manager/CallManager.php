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
    public function manageCalls(array $calls, array $elevators): array
    {
        $callGroups = $this->groupCallsByCallTime($calls);

        /** @var Call */
        foreach ($calls as $call) {
            $sameTimeCalls = $this->getSameTimeCalls($calls, $call->calledAt());

//            if(sizeof($sameTimeCalls) > sizeof($elevators)){
//                $sameTimeCalls = array_splice(
//                    $sameTimeCalls,
//                    0,
//                    - (sizeof($sameTimeCalls)-sizeof($elevators))
//                );
//            }
//
//            $this->assignElevators($sameTimeCalls, $elevators);
//            $this->freeElevators($elevators);

            //TODO: remove handled calls from array
        }

        return $calls;//TODO: fix this (will return empty array)
    }

    public function groupCallsByCallTime(array $calls): array
    {
        $callGroups = [];
        $callTimes = [];

        foreach ($calls as $call) {
            $callTime = $call->calledAt();

            if (!in_array($callTime, $callTimes)) {
                array_push($callTimes, $callTime);
            }
        }

        foreach ($callTimes as $key => $time) {
            $callGroups[$key] = [];

            foreach ($calls as $call) {
                if($call->calledAt() == $time) {
                    array_push($callGroups[$key], $call);
                }
            }
        }

        return $callGroups;
    }

    public function getCallIndex(array &$calls, Call $call): int
    {
        foreach ($calls as $index => $value) {
            if($value->id() == $call->id()) {
                return $index;
            }
        }
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
            $availableElevators = $this->getAvailableElevator($elevators);
            $closestElevator = $this->getClosestElevator($availableElevators, $call->origin());
            $closestElevator->take();
            $closestElevator->increaseFloorTrips(abs($closestElevator->currentFloor() - $call->destiny()));
            $closestElevator->moveToFloor($call->destiny());
            $call->completedBy($closestElevator);
            $this->appendCallReport($call->calledAt(), $closestElevator);
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

    private function appendCallReport(\DateTimeImmutable $time, Elevator $elevator)
    {
//        $this->reportBuilder->appendContent(
////           'Time: ' . $time->format('H:s') .
////           ' Elevator ID ' . $elevator->id() .
////           ' CurrentFloor ' . $elevator->currentFloor() .
////           ' Floors Travelled ' . $elevator->floorsTravelled() .
////           ' \r\n'
////        );
        echo('Time: ' . $time->format('H:m') .
            ' Elevator ID ' . $elevator->id() .
            ' CurrentFloor ' . $elevator->currentFloor() .
            ' Floors Travelled ' . $elevator->floorsTravelled() .
            ' \r\n');
    }
}
