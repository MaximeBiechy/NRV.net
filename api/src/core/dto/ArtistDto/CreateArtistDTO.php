<?php

namespace nrv\core\dto\patient;

use nrv\core\dto\DTO;

class CreateArtistDTO extends DTO
{
    protected string $name;
    protected string $style;
    protected string $image;

    public function __construct(Artist $a)
    {
        $this->name = $a->getName();
        $this->style = $a->getStyle(); 
        $this->image = $a->getImage();
}

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}