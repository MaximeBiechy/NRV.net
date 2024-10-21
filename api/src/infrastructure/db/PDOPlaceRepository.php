<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\place\Place;
use nrv\core\repositoryInterfaces\PlaceRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use Ramsey\Uuid\Uuid;

class PDOPlaceRepository implements PlaceRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPlaces(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM places');
        $places = [];
        while ($row = $stmt->fetch()) {
            $st = $this->pdo->prepare('SELECT * FROM images WHERE place_id = :place_id');
            $st->execute(['place_id' => $row['id']]);
            $images = $st->fetchAll();
            $row['images'] = $images;
            $places[] = new Place($row['name'], $row['address'], $row['nbSit'], $row['nbStand'], $row['images']);
        }
        return $places;
    }

    public function getPlaceById(int $id): Place
    {
        $stmt = $this->pdo->prepare('SELECT * FROM places WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $place = $stmt->fetch();
        if ($place === false) {
            throw new RepositoryEntityNotFoundException("Place not found");
        }
        $st = $this->pdo->prepare('SELECT * FROM images WHERE place_id = :place_id');
        $st->execute(['place_id' => $place['id']]);
        $images = $st->fetchAll();
        $place['images'] = $images;
        return new Place($place['name'], $place['address'], $place['nbSit'], $place['nbStand'], $place['images']);
    }

    public function save(Place $place): string
    {
        try {
            if ($place->getID() !== null) {
                $stmt = $this->pdo->prepare("UPDATE places SET name = :name, address = :address, nbSit = :nbSit, nbStand = :nbStand WHERE id = :id");
            } else {
                $id = Uuid::uuid4()->toString();
                $place->setID($id);
                $stmt = $this->pdo->prepare("INSERT INTO places (id, name, address, nbSit, nbStand) VALUES (:id, :name, :address, :nbSit, :nbStand)");
            }
            $stmt->execute([
                'id' => $place->getID(),
                'name' => $place->getName(),
                'address' => $place->getAddress(),
                'nbSit' => $place->getNbSit(),
                'nbStand' => $place->getNbStand()
            ]);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error while saving place");
        }

        return $place->getID();
    }
}