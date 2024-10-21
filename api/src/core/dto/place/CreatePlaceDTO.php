<?php

namespace nrv\core\dto\place;

use nrv\core\dto\DTO;

class CreatePlaceDTO extends DTO
{
    protected string $name, $address;
    protected int $nbSit, $nbStand;
    protected array $images;

    public function __construct(string $name, string $address,int $nbSit,int $nbStand, array $images) {
        $this->name = $name;
        $this->address = $address;
        $this->nbSit = $nbSit;
        $this->nbStand = $nbStand;
        $this->images = $images;
    }

}