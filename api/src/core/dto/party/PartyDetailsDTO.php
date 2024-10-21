<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\DTO;

class PartyDetailsDTO extends DTO
{
    protected string $id, $name, $theme;
    protected int $prices;
    protected \DateTimeImmutable $date, $begin;
    protected array $shows;

    public function __construct(Party $p)
    {
        $this->id = $p->getId();
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->prices = $p->getPrices();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
        $this->shows = $p->getShows();
    }
}