<?php

namespace nrv\core\dto\patient;

use nrv\core\dto\DTO;

class CreateArtistDTO extends DTO
{
    protected string $id;
    protected string $name;
    protected string $style;

    public function __construct(Artist $a)
    {
        $this->id = $a->getId();
        $this->name = $a->getName();
        $this->style = $a->getStyle(); 
}

    public function getId(): string
    {
        return $this->id;
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