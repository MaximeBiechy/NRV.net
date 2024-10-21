<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\party\Party;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use Ramsey\Uuid\Uuid;

class PDOPartyRepository implements PartyRepositoryInterface
{

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Party $party): string
    {
        try {
            if ($party->getID() !== null) {
                $stmt = $this->pdo->prepare('UPDATE party SET name = :name, theme = :theme, prices = :prices, date = :date, begin = :begin, shows = :shows, place = :place WHERE id = :id');
            } else {
                $id = Uuid::uuid4()->toString();
                $party->setID($id);
                $stmt = $this->pdo->prepare('INSERT INTO party (id, name, theme, prices, date, begin, shows, place) VALUES (:id, :name, :theme, :prices, :date, :begin, :shows, :place)');
            }
            $stmt->execute([
                'id' => $party->getID(),
                'name' => $party->getName(),
                'theme' => $party->getTheme(),
                'prices' => $party->getPrices(),
                'date' => $party->getDate(),
                'begin' => $party->getBegin(),
                'shows' => $party->getShows(),
                'place' => $party->getPlace()
            ]);
            return $party->getID();
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while saving party');
        }
    }

    public function getPartyById(string $id): Party
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM party WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $party = $stmt->fetch();
            if ($party === false) {
                throw new RepositoryInternalServerError('Party not found');
            }
            return new Party($party['id'], $party['name'], $party['theme'], $party['prices'], $party['date'], $party['begin'], $party['shows'], $party['place']);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while getting party');
        }
    }
}