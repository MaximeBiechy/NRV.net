<?php

namespace nrv\core\dto\artist;

use nrv\core\domain\entities\Artist\Artist;
use nrv\core\dto\DTO;

class CreateArtistDTO extends DTO
{
    protected string $name;
    protected array $style;
    protected string $image;

    public function __construct(Artist $a)
    {
        $this->name = $a->getName();
        $this->style = $a->getStyles();
        $this->image = $a->getImage();
    }
}