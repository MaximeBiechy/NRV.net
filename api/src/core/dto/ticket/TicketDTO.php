<?php

namespace nrv\core\dto\ticket;

use nrv\core\dto\DTO;

class TicketDTO extends DTO
{
    protected string $name;
    protected int $price;

    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

}