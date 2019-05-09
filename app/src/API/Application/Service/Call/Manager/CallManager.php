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
        $callGroups = $this->groupCalls($calls);

        foreach ($callGroups as $callGroup) {
            $this->assignElevators($callGroup, $elevators);
        }

        $this->reportBuilder->generateReport();

        return $calls;
    }

    private function groupCalls(array $calls): array
    {
        $callGroups = [];
        $callTimes = $this->getCallTimes($calls);

        foreach ($callTimes as $key => $time) {
            $callGroups[$key] = $this->groupCallsByCallTime($calls, $time);
        }

        return $callGroups;
    }

    private function getCallTimes(array $calls): array
    {
        $callTimes = [];

        foreach ($calls as $call) {
            $callTime = $call->calledAt();

            if (!in_array($callTime, $callTimes)) {
                array_push($callTimes, $callTime);
            }
        }

        return $callTimes;
    }

    private function groupCallsByCallTime(array $calls,\DateTimeImmutable $callTime): array
    {
        $result = [];

        foreach ($calls as $call) {
            if($call->calledAt() == $callTime) {
                array_push($result, $call);
            }
        }

        return $result;
    }

    /**
     * @param Call[]
     * @param Elevator[]
     * @return void
     */
    private function assignElevators(array $callGroup, array &$elevators): void
    {
        foreach ($callGroup as $call) {
            $availableElevators = $this->getAvailableElevators($elevators);

            if(!empty($availableElevators)) { //TODO: manage if no free elevators
                $closestElevator = $this->getClosestElevator($availableElevators, $call->origin());
                $closestElevator->take();
                $elevatorDistanceFromCallOrigin = abs($closestElevator->currentFloor() - $call->origin());
                $closestElevator->increaseFloorTrips(
                    abs($call->origin() - $call->destiny()) + $elevatorDistanceFromCallOrigin
                );
                $closestElevator->moveToFloor($call->destiny());
                $call->completedBy($closestElevator);
                $this->appendCallReport($call->calledAt(), $closestElevator);
            }
        }
        $this->freeElevators($elevators);
    }

    /**
     * @param array $elevators
     * @return array
     */
    private function getAvailableElevators(array $elevators): ?array
    {
        $availableElevators = [];

        foreach ($elevators as $elevator) {
            if ($elevator->isEmpty()) {
                array_push($availableElevators, $elevator);
            }
        }

        return $availableElevators;
    }

    /**
     * @param array $elevators
     * @param int $callOrigin
     * @return Elevator
     */
    private function getClosestElevator(array $elevators, int $callOrigin): Elevator
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
    private function freeElevators(array $elevators): void
    {
        foreach ($elevators as $elevator) {
            $elevator->free();
        }
    }

    private function appendCallReport(\DateTimeImmutable $time, Elevator $elevator)
    {
        $this->reportBuilder->appendContent(
           'Time: ' . $time->format('H:i') .
           ' Elevator ID ' . $elevator->id() .
           ' CurrentFloor ' . $elevator->currentFloor() .
           ' Floors Travelled ' . $elevator->floorsTravelled() .
           ' \r\n'
        );
    }
}
