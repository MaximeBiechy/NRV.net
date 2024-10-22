<?php

namespace nrv\core\dto\ticket;

use nrv\core\dto\DTO;

class CreateTicketDTO extends DTO
{
    protected string $name, $party_id;
    protected int $price, $quantity;

    public function __construct(string $name, int $price, int $quantity, string $party_id)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->party_id = $party_id;
    }

}