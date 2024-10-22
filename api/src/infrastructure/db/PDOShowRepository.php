<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\artist\Artist;
use nrv\core\domain\entities\show\Show;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;
use Ramsey\Uuid\Uuid;

class PDOShowRepository implements ShowRepositoryInterface
{
    private \PDO $pdo_show;

    public function __construct(\PDO $pdo_show)
    {
        $this->pdo_show = $pdo_show;
    }

    public function save(Show $show): string
    {
        try{
            if ($show->getID() !== null) {
                $stmt = $this->pdo_show->prepare("UPDATE shows SET title = :title, description = :description, video = :video, begin = :begin WHERE id = :id");
            }else{
                $id = Uuid::uuid4()->toString();
                $show->setID($id);
                $stmt = $this->pdo_show->prepare("INSERT INTO shows (id, title, description, video, begin) VALUES (:id, :title, :description, :video, :begin)");
            }
            $stmt->execute([
                'id' => $show->getID(),
                'title' => $show->getTitle(),
                'description' => $show->getDescription(),
                'video' => $show->getVideo(),
                'begin' => $show->getBegin()
            ]);
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while saving show");
        }

        return $show->getID();
    }

    public function getShows(): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM shows");
            $stmt->execute();
            $shows = $stmt->fetchAll();
            $result = [];
            foreach ($shows as $show) {
                $stmt = $this->pdo_show->prepare("SELECT * FROM artists INNER JOIN perform ON artists.id = perform.artist_id WHERE perform.show_id = :show_id");
                $stmt->execute(['show_id' => $show['id']]);
                $artists = $stmt->fetchAll();
                $ars = [];
                foreach ($artists as $artist) {
                    $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                    $a->setID($artist['id']);
                    $ars[] = $a;
                }
                $stmt = $this->pdo_show->prepare("SELECT * FROM images WHERE show_id = :show_id");
                $stmt->execute(['show_id' => $show['id']]);
                $images = $stmt->fetchAll();
                $is =[];
                foreach ($images as $image) {
                    $is[] = $image['path'];
                }
                $s = new Show($show['title'], $show['description'], $show['video'], $is, $ars, \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $show['begin']));
                $s->setID($show['id']);
                $result[] = $s;
            }
            return $result;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching shows");
        }
    }

    public function getShowById(string $id): Show
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM shows WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $show = $stmt->fetch();
            if ($show === false) {
                throw new RepositoryEntityNotFoundException("Show not found");
            }
            $stmt = $this->pdo_show->prepare("SELECT * FROM artists INNER JOIN perform ON artists.id = perform.artist_id WHERE perform.show_id = :show_id");
            $stmt->execute(['show_id' => $show['id']]);
            $artists = $stmt->fetchAll();
            $show['artists'] = $artists;
            $stmt = $this->pdo_show->prepare("SELECT * FROM images WHERE show_id = :show_id");
            $stmt->execute(['show_id' => $show['id']]);
            $images = $stmt->fetchAll();
            $is =[];
            foreach ($images as $image) {
                $is[] = $image['path'];
            }
            $s = new Show($show['title'], $show['description'], $show['video'],$is,$show['artists'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $show['begin']));
            $s->setID($show['id']);
            return $s;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching show");
        }
    }
}