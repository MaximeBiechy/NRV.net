<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;

interface TicketRepositoryInterface
{
    public function saveTicket(Ticket $ticket): string;
    public function saveSoldTicket(SoldTicket $soldTicket): string;
    public function getTicketById(string $id): Ticket;
    public function getSoldTicketById(string $id): SoldTicket;
    public function getSoldTicketsByUserID(string $userID): array;
    public function getTicketsByCardID(string $cardID): array;
    public function addTicketToCard(string $ticketID, string $cardID): void;
}