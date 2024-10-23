<?php

namespace nrv\core\dto\cart;

use nrv\core\dto\DTO;

class AddTicketToCartDTO extends DTO
{
    protected string $card_id, $ticket_id;

    public function __construct(string $card_id, string $ticket_id)
    {
        $this->card_id = $card_id;
        $this->ticket_id = $ticket_id;
    }

}