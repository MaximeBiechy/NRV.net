<?php

namespace nrv\core\services\ticket;

use nrv\core\dto\card\AddTicketToCardDTO;
use nrv\core\dto\card\CardDTO;
use nrv\core\dto\ticket\SoldTicketDTO;
use nrv\core\dto\ticket\TicketDTO;

interface TicketServiceInterface
{
    public function addTicketToCard(AddTicketToCardDTO $dto): void;
    public function getTicketsFromCard(string $id): array;
    public function createTicket(TicketDTO $ticketDTO): TicketDTO;
    public function getTicket(string $ticketId): TicketDTO;
    public function createSoldTicket(SoldTicketDTO $ticketDTO): SoldTicketDTO;
    public function getSoldTicket(string $ticketId): SoldTicketDTO;
    public function getCardByUserId(string $userId): CardDTO;
    public function validateCard(string $cardId): CardDTO;
    public function validateCommand(string $cardId): CardDTO;
}