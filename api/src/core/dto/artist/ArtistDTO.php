<?php

namespace nrv\core\dto\artist;

use nrv\core\domain\entities\Artist\Artist;
use nrv\core\dto\DTO;

class ArtistDTO extends DTO
{
    protected string $id;
    protected string $name;
    protected string $style;
    protected string $image;

    public function __construct(Artist $a)
    {
        $this->id = $a->getId();
        $this->name = $a->getName();
        $this->style = $a->getStyle();
        $this->image = $a->getImage();
    }

}