<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\party\Party;
use nrv\core\domain\entities\place\Place;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use Ramsey\Uuid\Uuid;

class PDOPartyRepository implements PartyRepositoryInterface
{

    private \PDO $pdo_party, $pdo_place;

    public function __construct(\PDO $pdo_party, \PDO $pdo_place)
    {
        $this->pdo_party = $pdo_party;
        $this->pdo_place = $pdo_place;
    }

    public function save(Party $party): string
    {
        try {
            if ($party->getID() !== null) {
                $stmt = $this->pdo_party->prepare('UPDATE party SET name = :name, theme = :theme, price = :price, date = :date, begin = :begin, show1_id = :show1_id, show2_id = :show2_id, show3_id = :show3_id, place_id = :place WHERE id = :id');
            } else {
                $id = Uuid::uuid4()->toString();
                $party->setID($id);
                $stmt = $this->pdo_party->prepare('INSERT INTO party (id, name, theme, price, date, begin, show1_id, show2_id, show3_id, place_id) VALUES (:id, :name, :theme, :price, :date, :begin, :show1_id, :show2_id, :show2_id, :place)');
            }
            $stmt->execute([
                'id' => $party->getID(),
                'name' => $party->getName(),
                'theme' => $party->getTheme(),
                'price' => $party->getPrice(),
                'date' => $party->getDate(),
                'begin' => $party->getBegin(),
                'show1_id' => $party->getShows()[0],
                'show2_id' => $party->getShows()[1]??null,
                'show3_id' => $party->getShows()[2]??null,
                'place' => $party->getPlace()->getID()
            ]);
            return $party->getID();
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while saving party');
        }
    }

    public function getPartyById(string $id): Party
    {
        try {
            $stmt = $this->pdo_party->prepare('SELECT * FROM party WHERE id = :id');
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
            $stmt = $this->pdo_place->prepare('SELECT * FROM places WHERE id = :id');
            $stmt->execute(['id' => $party['place_id']]);
            $place = $stmt->fetch();
            if ($place === false) {
                throw new RepositoryInternalServerError('Place not found');
            }
            $stmt = $this->pdo_place->prepare('SELECT * FROM images WHERE place_id = :id');
            $stmt->execute(['id' => $party['place_id']]);
            $is = [];
            $images = $stmt->fetchAll();
            foreach ($images as $image) {
                $is[] = $image['path'];
            }
            $p = new Place($place['name'], $place['address'], $place['nb_sit'], $place['nb_stand'], $is);
            $p->setID($place['id']);

            $p = new Party($party['name'], $party['theme'], $party['price'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['date']), \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $party['begin']), $shows, $p);
            $p->setID($party['id']);
            return $p;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError('Error while getting party');
        }
    }

    public function getParties(): array
    {
        try {
            $stmt = $this->pdo_party->prepare('SELECT * FROM party');
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
            $stmt = $this->pdo_party->prepare('SELECT * FROM party WHERE show1_id = :shows OR show2_id = :shows OR show3_id = :shows');
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