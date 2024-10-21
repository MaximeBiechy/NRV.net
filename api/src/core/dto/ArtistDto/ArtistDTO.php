<?php

namespace nrv\core\dto\patient;

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

    public function getImage(): string
    {
        return $this->image;
    }
}