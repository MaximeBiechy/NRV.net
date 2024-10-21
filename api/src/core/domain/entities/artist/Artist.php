<?php

namespace nrv\core\domain\entities\Artist;

use nrv\core\domain\entities\Entity;


class Artist extends Entity
{
    private string $id;
    private string $name;
    private array $styles;

    public function __construct(string $id, string $name, array $styles)
    {   
        $this->id = $id;
        $this->name = $name;
        $this->styles = $styles;
    }

    public function getId(): string
    {
        return $this->id;
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