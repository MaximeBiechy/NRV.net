<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\DTO;

class PartyDTO extends DTO
{
    protected string $id, $name, $theme;
    protected \DateTimeImmutable $date, $begin;

    public function __construct(Party $p) {
        $this->id = $p->getId();
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
    }


}