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
    private \PDO $pdo_place;
    private \PDO $pdo_party;

    public function __construct(\PDO $pdo_show, \PDO $pdo_place, \PDO $pdo_party)
    {
        $this->pdo_show = $pdo_show;
        $this->pdo_place = $pdo_place;
        $this->pdo_party = $pdo_party;
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

    public function getArtists(): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM artists");
            $stmt->execute();
            $artists = $stmt->fetchAll();
            $result = [];
            foreach ($artists as $artist) {
                $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                $a->setID($artist['id']);
                $result[] = $a;
            }
            return $result;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching artists");
        }
    }

    public function getArtistById(string $id): Artist
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM artists WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $artist = $stmt->fetch();
            if ($artist === false) {
                throw new RepositoryEntityNotFoundException("Artist not found");
            }
            $a = new Artist($artist['name'], $artist['style'], $artist['image']);
            $a->setID($artist['id']);
            return $a;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching artist");
        }
    }


    public function getShowsByDate(string $date): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM shows WHERE DATE(begin) = :begin");
            $stmt->execute(['begin' => $date]);
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

    public function getShowsByStyle(string $style_name): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT shows.id, shows.title, shows.description, shows.video, shows.begin FROM shows INNER JOIN perform ON shows.id = perform.show_id INNER JOIN artists ON perform.artist_id = artists.id WHERE artists.style = :style");
            $stmt->execute(['style' => $style_name]);
            $shows = $stmt->fetchAll();
            $result = [];
            foreach ($shows as $show) {
                $stmt = $this->pdo_show->prepare("SELECT * FROM artists INNER JOIN perform ON artists.id = perform.artist_id WHERE perform.show_id = :show_id");
                $stmt->execute(['show_id' => $show[0]]);
                $artists = $stmt->fetchAll();
                $ars = [];
                foreach ($artists as $artist) {
                    $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                    $a->setID($artist['id']);
                    $ars[] = $a;
                }
                $stmt = $this->pdo_show->prepare("SELECT * FROM images WHERE show_id = :show_id");
                $stmt->execute(['show_id' => $show[0]]);
                $images = $stmt->fetchAll();
                $is =[];
                foreach ($images as $image) {
                    $is[] = $image['path'];
                }
                $s = new Show($show['title'], $show['description'], $show['video'], $is, $ars, \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $show['begin']));
                $s->setID($show[0]);
                $result[] = $s;
            }
            return $result;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching shows");
        }
    }

    public function getShowsByPlace(string $place_name): array
    {
        try{
            $stmt = $this->pdo_place->prepare("SELECT * FROM places WHERE name = :name");
            $stmt->execute(['name' => $place_name]);
            $place = $stmt->fetch();
            if ($place === false) {
                throw new RepositoryEntityNotFoundException("Place not found");
            }
            $stmt = $this->pdo_party->prepare("SELECT * FROM party WHERE place_id = :place_id");
            $stmt->execute(['place_id' => $place['id']]);
            $parties = $stmt->fetchAll();
            $result = [];
            foreach ($parties as $party) {
                $stmt = $this->pdo_show->prepare("SELECT * FROM shows WHERE id = :id1 or id = :id2 or id = :id3");
                $stmt->execute([
                    'id1' => $party['show1_id'],
                    'id2' => $party['show2_id'],
                    'id3' => $party['show3_id']
                ]);
                $shows = $stmt->fetchAll();
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
            }
            return $result;

        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching shows");
        }
    }

    public function getShowsPaginated(int $page, int $size): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM shows LIMIT :size OFFSET :offset");
            $stmt->execute([
                'size' => $size,
                'offset' => ($page - 1) * $size
            ]);
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

    public function getShowsByDatePaginated(string $date, int $page, int $size): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT * FROM shows WHERE DATE(begin) = :begin LIMIT :size OFFSET :offset");
            $stmt->execute([
                'begin' => $date,
                'size' => $size,
                'offset' => ($page - 1) * $size
            ]);
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

    public function getShowsByStylePaginated(string $style_name, int $page, int $size): array
    {
        try{
            $stmt = $this->pdo_show->prepare("SELECT shows.id, shows.title, shows.description, shows.video, shows.begin FROM shows INNER JOIN perform ON shows.id = perform.show_id INNER JOIN artists ON perform.artist_id = artists.id WHERE artists.style = :style LIMIT :size OFFSET :offset");
            $stmt->execute([
                'style' => $style_name,
                'size' => $size,
                'offset' => ($page - 1) * $size
            ]);
            $shows = $stmt->fetchAll();
            $result = [];
            foreach ($shows as $show) {
                $stmt = $this->pdo_show->prepare("SELECT * FROM artists INNER JOIN perform ON artists.id = perform.artist_id WHERE perform.show_id = :show_id");
                $stmt->execute(['show_id' => $show[0]]);
                $artists = $stmt->fetchAll();
                $ars = [];
                foreach ($artists as $artist) {
                    $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                    $a->setID($artist['id']);
                    $ars[] = $a;
                }
                $stmt = $this->pdo_show->prepare("SELECT * FROM images WHERE show_id = :show_id");
                $stmt->execute(['show_id' => $show[0]]);
                $images = $stmt->fetchAll();
                $is =[];
                foreach ($images as $image) {
                    $is[] = $image['path'];
                }
                $s = new Show($show['title'], $show['description'], $show['video'], $is, $ars, \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $show['begin']));
                $s->setID($show[0]);
                $result[] = $s;
            }
            return $result;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching shows");
        }
    }

    public function getShowsByPlacePaginated(string $place_name, int $page, int $size): array
    {
        try{
            $stmt = $this->pdo_place->prepare("SELECT * FROM places WHERE name = :name");
            $stmt->execute(['name' => $place_name]);
            $place = $stmt->fetch();
            if ($place === false) {
                throw new RepositoryEntityNotFoundException("Place not found");
            }
            $stmt = $this->pdo_party->prepare("SELECT * FROM party WHERE place_id = :place_id");
            $stmt->execute(['place_id' => $place['id']]);
            $parties = $stmt->fetchAll();
            $result = [];
            foreach ($parties as $party) {
                $stmt = $this->pdo_show->prepare("SELECT * FROM shows WHERE id = :id1 or id = :id2 or id = :id3 LIMIT :size OFFSET :offset");
                $stmt->execute([
                    'id1' => $party['show1_id'],
                    'id2' => $party['show2_id'],
                    'id3' => $party['show3_id'],
                    'size' => $size,
                    'offset' => ($page - 1) * $size
                ]);
                $shows = $stmt->fetchAll();
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
            }
            return $result;

        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching shows");
        }
    }

}