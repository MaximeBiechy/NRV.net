<?php

namespace nrv\core\dto\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\DTO;

class CreatePartyDTO extends DTO
{
    protected string $name, $theme;
    protected \DateTimeImmutable $date, $begin;

    public function __construct(Party $p) {
        $this->name = $p->getName();
        $this->theme = $p->getTheme();
        $this->date = $p->getDate();
        $this->begin = $p->getBegin();
    }
}