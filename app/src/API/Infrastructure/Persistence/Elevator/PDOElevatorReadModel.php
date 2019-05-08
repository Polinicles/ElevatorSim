<?php

namespace App\API\Infrastructure\Persistence\Elevator;

use App\API\Application\Service\Elevator\DTO\ElevatorDTO;
use App\API\Domain\Model\Elevator\ElevatorReadModel;
use Doctrine\DBAL\Connection;
use PDO;

class PDOElevatorReadModel implements ElevatorReadModel
{
    /** @var PDO  */
    private $pdo;


    public function __construct(Connection $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritdoc
     */
    public function list(): array
    {
        $sql =<<<SQL
            SELECT
                e.uuid
            FROM elevators e
SQL;

        $listElevators = $this->pdo->prepare($sql);
        $listElevators->execute();
        $listElevatorsData = $listElevators->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $listElevators) {
            return new ElevatorDTO(
                $listElevators['uuid']
            );
        }, $listElevatorsData);
    }
}
