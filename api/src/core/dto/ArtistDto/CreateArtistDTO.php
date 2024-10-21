<?php

namespace nrv\core\dto\patient;

use nrv\core\dto\DTO;

class CreateArtistDTO extends DTO
{
    protected string $name;
    protected string $style;

    public function __construct(Artist $a)
    {
        $this->name = $a->getName();
        $this->style = $a->getStyle(); 
}

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyle(): string
    {
        return $this->style;
    }
}