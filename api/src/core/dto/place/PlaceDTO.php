<?php

namespace nrv\core\dto\place;

use nrv\core\domain\entities\place\string;
use nrv\core\dto\DTO;

class PlaceDTO extends DTO
{
    protected string $id, $name, $address;
    protected int $nbSit, $nbStand;
    protected array $images;

    public function __construct(string $place) {
        $this->id = $place->getId();
        $this->name = $place->getName();
        $this->address = $place->getAddress();
        $this->nbSit = $place->getNbSit();
        $this->nbStand = $place->getNbStand();
        $this->images = $place->getImages();
    }

}