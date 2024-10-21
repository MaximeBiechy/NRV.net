<?php

namespace nrv\core\domain\entities\Artist;

use nrv\core\domain\entities\Entity;


class Artist extends Entity
{
    private string $name;
    private array $styles;
    private string $image;

    public function __construct(string $name, array $styles, string $image)
    {   
        $this->name = $name;
        $this->styles = $styles;
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

    public function getImage(): string
    {
        return $this->image;
    }


}