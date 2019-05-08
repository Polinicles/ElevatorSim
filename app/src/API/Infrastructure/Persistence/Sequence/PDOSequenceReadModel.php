<?php

namespace App\API\Infrastructure\Persistence\Sequence;

use App\API\Application\Service\Sequence\DTO\SequenceDTO;
use App\API\Domain\Model\Sequence\SequenceReadModel;
use Doctrine\DBAL\Connection;
use PDO;

class PDOSequenceReadModel implements SequenceReadModel
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
                s.start,
                s.end,
                s.origin,
                s.destiny,
                s.ocurrence
            FROM sequences s
SQL;

        $listSequences = $this->pdo->prepare($sql);
        $listSequences->execute();
        $listSequencesData = $listSequences->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $listSequencesData) {
            return new SequenceDTO(
                $listSequencesData['ocurrence'],
                new \DateTimeImmutable($listSequencesData['start']),
                new \DateTimeImmutable($listSequencesData['end']),
                json_decode($listSequencesData['origin']),
                $listSequencesData['destiny']
            );
        }, $listSequencesData);
    }
}
