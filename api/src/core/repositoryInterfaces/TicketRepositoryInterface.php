<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;

interface TicketRepositoryInterface
{
    public function save(Ticket $ticket): string;
    public function getTicketById(string $id): Ticket;
    public function getTicketsByUserID(string $userID): array;
}