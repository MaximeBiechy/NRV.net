<?php

namespace nrv\core\dto\ticket;

use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\dto\DTO;

class SoldTicketDTO extends DTO
{
    protected string $id, $name, $user_id, $ticket_id, $party_id;
    protected int $price;

    public function __construct(SoldTicket $soldTicket)
    {
        $this->id = $soldTicket->getId();
        $this->name = $soldTicket->getName();
        $this->price = $soldTicket->getPrice();
        $this->user_id = $soldTicket->getUserId();
        $this->ticket_id = $soldTicket->getTicketId();
        $this->party_id = $soldTicket->getPartyId();
    }

}