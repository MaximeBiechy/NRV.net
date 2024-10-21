<?php

namespace nrv\core\dto\show;

use nrv\core\domain\entities\show\Show;
use nrv\core\dto\DTO;

class ShowDTO extends DTO
{
    protected string $id, $title, $description, $video;
    protected array $images;
    protected array $artists;
    protected \DateTimeImmutable $begin;

    public function __construct(Show $show) {
        $this->id = $show->getId();
        $this->title = $show->getTitle();
        $this->description = $show->getDescription();
        $this->video = $show->getVideo();
        $this->images = $show->getImages();
        $this->artists = $show->getArtists();
        $this->begin = $show->getBegin();
    }

}