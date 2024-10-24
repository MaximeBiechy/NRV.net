<?php

namespace nrv\core\domain\entities\place;

use nrv\core\domain\entities\Entity;

class Place extends Entity
{
    protected string $name, $address;
    protected int $nbSit, $nbStand;
    protected array $images;

    public function __construct(string $name, string $address, int $nbSit, int $nbStand, array $images) {
        $this->name = $name;
        $this->address = $address;
        $this->nbSit = $nbSit;
        $this->nbStand = $nbStand;
        $this->images = $images;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getNbSit(): int {
        return $this->nbSit;
    }

    public function getNbStand(): int {
        return $this->nbStand;
    }

    public function getImages(): array {
        return $this->images;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNbSit(int $nbSit): void
    {
        $this->nbSit = $nbSit;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setNbStand(int $nbStand): void
    {
        $this->nbStand = $nbStand;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }




}