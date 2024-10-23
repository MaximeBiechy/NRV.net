<?php

namespace nrv\core\services\ticket;

use nrv\core\dto\cart\AddTicketToCartDTO;
use nrv\core\dto\cart\CartDTO;
use nrv\core\dto\ticket\SoldTicketDTO;
use nrv\core\dto\ticket\TicketDTO;

interface TicketServiceInterface
{
    public function addTicketTocart(AddTicketToCartDTO $dto): void;
    public function getTicketsFromcart(string $id): array;
    public function createTicket(TicketDTO $ticketDTO): TicketDTO;
    public function getTicket(string $ticketId): TicketDTO;
    public function createSoldTicket(SoldTicketDTO $ticketDTO): SoldTicketDTO;
    public function getSoldTicket(string $ticketId): SoldTicketDTO;
    public function getCartByUserId(string $userId): CartDTO;
    public function validateCart(string $cartId): CartDTO;
    public function validateCommand(string $cartId): CartDTO;
    public function payCart(string $cartId): CartDTO;
    public function getTicketsByPartyId(string $partyId): array;
}