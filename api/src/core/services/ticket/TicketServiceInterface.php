<?php

namespace nrv\core\services\ticket;

use nrv\core\dto\ticket\CreateTicketDTO;
use nrv\core\dto\ticket\TicketDTO;

interface TicketServiceInterface
{
    public function getTicketsByUserID(string $userID): array;
    public function getTicketById(string $id): TicketDTO;
    public function createTicket(CreateTicketDTO $ticket): TicketDTO;
}