<?php

namespace nrv\core\dto\ticket;

use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\dto\DTO;

class TicketDTO extends DTO
{
    protected string $id, $name, $party_id;
    protected int $price, $quantity;

    public function __construct(Ticket $ticket)
    {
        $this->id = $ticket->getId();
        $this->name = $ticket->getName();
        $this->price = $ticket->getPrice();
        $this->quantity = $ticket->getQuantity();
        $this->party_id = $ticket->getPartyId();
    }

}