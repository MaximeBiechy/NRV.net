<?php

namespace nrv\core\domain\entities\artist;

use nrv\core\domain\entities\Entity;


class Artist extends Entity
{
    private string $name;
    private string $styles;
    private string $image;

    public function __construct(string $name, string $styles, string $image)
    {   
        $this->name = $name;
        $this->styles = $styles;
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyle(): string
    {
        return $this->styles;
    }

    public function getImage(): string
    {
        return $this->image;
    }


}