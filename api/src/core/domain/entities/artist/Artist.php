<?php

namespace nrv\core\domain\entities\Artist;

use nrv\core\domain\entities\Entity;


class Artist extends Entity
{
    private string $name;
    private array $styles;

    public function __construct(string $name, array $styles)
    {   
        $this->name = $name;
        $this->styles = $styles;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }


}