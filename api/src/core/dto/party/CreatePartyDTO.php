<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\domain\entities\place\Place;
use nrv\core\dto\DTO;

class CreatePartyDTO extends DTO
{
    protected string $name, $theme;
    protected int $price;
    protected \DateTimeImmutable $date, $begin;
    protected array $shows;
    protected Place $place;

    public function __construct(Party $p) {
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->price = $p->getPrice();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
        $this->shows = $p->getShows();
        $this->place = $p->getPlace();
    }
}