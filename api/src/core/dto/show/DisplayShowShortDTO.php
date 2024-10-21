<?php

namespace nrv\core\dto\show;

use nrv\core\domain\entities\show\Show;
use nrv\core\dto\DTO;

class DisplayShowShortDTO extends DTO
{
    protected string $id, $title;
    protected array $images;
    protected \DateTimeImmutable $begin;

    public function __construct(Show $show) {
        $this->id = $show->getId();
        $this->title = $show->getTitle();
        $this->images = $show->getImages();
        $this->begin = $show->getBegin();
    }

}