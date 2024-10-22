<?php

namespace nrv\core\domain\entities\party;

use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\place\Place;

class Party extends Entity
{
    private string $name, $theme;
    private int $price;
    private \DateTimeImmutable $date, $begin;
    private array $shows;
    private Place $place;

    public function __construct(string $name, string $theme, int $prices, \DateTimeImmutable $date, \DateTimeImmutable $begin, array $shows, Place $place)
    {
        $this->name = $name;
        $this->theme = $theme;
        $this->price = $prices;
        $this->date = $date;
        $this->begin = $begin;
        $this->shows = $shows;
        $this->place = $place;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getBegin(): \DateTimeImmutable
    {
        return $this->begin;
    }

    public function setBegin(\DateTimeImmutable $begin): void
    {
        $this->begin = $begin;
    }

    public function getShows(): array
    {
        return $this->shows;
    }

    public function setShows(array $shows): void
    {
        $this->shows = $shows;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): void
    {
        $this->place = $place;
    }


}