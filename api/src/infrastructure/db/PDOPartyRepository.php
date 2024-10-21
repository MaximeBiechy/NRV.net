<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\party\Party;
use nrv\core\domain\entities\place\Place;
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
                $stmt = $this->pdo->prepare('UPDATE party SET name = :name, theme = :theme, price = :price, date = :date, begin = :begin, show1_id = :show1_id, show2_id = :show2_id, show3_id = :show3_id, place = :place WHERE id = :id');
            } else {
                $id = Uuid::uuid4()->toString();
                $party->setID($id);
                $stmt = $this->pdo->prepare('INSERT INTO party (id, name, theme, price, date, begin, show1_id, show2_id, show3_id, place) VALUES (:id, :name, :theme, :price, :date, :begin, :show1_id, :show2_id, :show2_id, :place)');
            }
            $stmt->execute([
                'id' => $party->getID(),
                'name' => $party->getName(),
                'theme' => $party->getTheme(),
                'price' => $party->getPrices(),
                'date' => $party->getDate(),
                'begin' => $party->getBegin(),
                'show1_id' => $party->getShows()[0],
                'show2_id' => $party->getShows()[1]??null,
                'show3_id' => $party->getShows()[2]??null,
                'place' => $party->getPlaceID()
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
            $shows = [];
            if ($party['show1_id'] !== null) {
                $shows[] = $party['show1_id'];
            }
            if ($party['show2_id'] !== null) {
                $shows[] = $party['show2_id'];
            }
            if ($party['show3_id'] !== null) {
                $shows[] = $party['show3_id'];
            }
            $p = new Party($party['name'], $party['theme'], $party['price'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['date']), \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['begin']), $shows, $party['place_id']);
            $p->setID($party['id']);
            return $p;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while getting party');
        }
    }

    public function getParties(): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM party');
            $stmt->execute();
            $parties = $stmt->fetchAll();
            foreach ($parties as $party) {
                $shows = [];
                if ($party['show1_id'] !== null) {
                    $shows[] = $party['show1_id'];
                }
                if ($party['show2_id'] !== null) {
                    $shows[] = $party['show2_id'];
                }
                if ($party['show3_id'] !== null) {
                    $shows[] = $party['show3_id'];
                }
                $p = new Party($party['name'], $party['theme'], $party['price'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['date']), \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['begin']), $shows, $party['place_id']);
                $p->setID($party['id']);
                $part[] = $p;
            }
            return $part;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while getting parties');
        }
    }

    public function getPartyByShow(string $showId): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM party WHERE show1_id = :shows OR show2_id = :shows OR show3_id = :shows');
            $stmt->execute(['shows' => $showId]);
            $parties = $stmt->fetchAll();
            $part = [];
            foreach ($parties as $party) {
                $shows = [];
                if ($party['show1_id'] !== null) {
                    $shows[] = $party['show1_id'];
                }
                if ($party['show2_id'] !== null) {
                    $shows[] = $party['show2_id'];
                }
                if ($party['show3_id'] !== null) {
                    $shows[] = $party['show3_id'];
                }
                $p = new Party($party['name'], $party['theme'], $party['price'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['date']), \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['begin']), $shows, $party['place_id']);
                $p->setID($party['id']);
                $part[] = $p;
            }
            return $part;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while getting parties');
        }
    }
}