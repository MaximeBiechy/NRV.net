<?php

namespace nrv\core\dto\show;

use nrv\core\dto\DTO;

class CreateShowDTO extends DTO
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

}