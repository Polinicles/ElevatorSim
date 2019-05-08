<?php

namespace App\API\Infrastructure\Persistence\Call;

use App\API\Application\Service\Call\DTO\CallDTO;
use App\API\Domain\Model\Call\CallReadModel;
use Doctrine\DBAL\Connection;
use PDO;

class PDOCallReadModel implements CallReadModel
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
                c.uuid,
                c.called_at,
                c.origin,
                c.destiny
            FROM calls c
            ORDER BY c.called_at ASC
SQL;

        $listCalls = $this->pdo->prepare($sql);
        $listCalls->execute();
        $listCallsData = $listCalls->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $listCallsData) {
            return new CallDTO(
                $listCallsData['uuid'],
                new \DateTimeImmutable($listCallsData['called_at']),
                $listCallsData['origin'],
                $listCallsData['destiny']
            );
        }, $listCallsData);
    }
}
