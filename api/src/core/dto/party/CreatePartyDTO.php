<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\DTO;

class CreatePartyDTO extends DTO
{
    protected string $name, $theme, $place_id;
    protected int $price;
    protected \DateTimeImmutable $date, $begin;
    protected array $shows;

    public function __construct(Party $p) {
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->price = $p->getPrice();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
        $this->shows = $p->getShows();
        $this->place_id = $p->getPlaceID();
    }
}