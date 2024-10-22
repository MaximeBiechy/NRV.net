<?php

namespace nrv\core\domain\entities\show;

use nrv\core\domain\entities\Entity;

class Show extends Entity
{
    protected string $title, $description, $video;
    protected array $images;
    protected array $artists;
    protected \DateTimeImmutable $begin;

    public function __construct(string $title, string $description, string $video, array $images, array $artists, \DateTimeImmutable $date) {
        $this->title = $title;
        $this->description = $description;
        $this->video = $video;
        $this->images = $images;
        $this->artists = $artists;
        $this->begin = $date;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getVideo(): string {
        return $this->video;
    }

    public function getImages(): array {
        return $this->images;
    }

    public function getArtists(): array {
        return $this->artists;
    }

    public function getBegin(): \DateTimeImmutable {
        return $this->begin;
    }

    public function setArtists(array $artists): void {
        $this->artists = $artists;
    }

}