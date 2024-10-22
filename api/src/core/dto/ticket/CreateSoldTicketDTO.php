<?php

namespace nrv\core\dto\ticket;

use nrv\core\dto\DTO;

class CreateSoldTicketDTO extends DTO
{
    protected string $name, $user_id, $ticket_id, $party_id;
    protected int $price;

    public function __construct(string $name, int $price, string $user_id, string $ticket_id, string $party_id)
    {
        $this->name = $name;
        $this->price = $price;
        $this->user_id = $user_id;
        $this->ticket_id = $ticket_id;
        $this->party_id = $party_id;
    }

}