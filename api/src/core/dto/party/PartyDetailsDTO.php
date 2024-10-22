<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\DTO;

class PartyDetailsDTO extends DTO
{
    protected string $id, $name, $theme;
    protected int $price;
    protected \DateTimeImmutable $date, $begin;
    protected array $shows;

    public function __construct(Party $p)
    {
        $this->id = $p->getId();
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->price = $p->getPrice();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
        $this->shows = $p->getShows();
    }
}