<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;

interface TicketRepositoryInterface
{
    public function saveTicket(Ticket $ticket): string;
    public function saveSoldTicket(SoldTicket $soldTicket): string;
    public function getTicketById(string $id): Ticket;
    public function getSoldTicketById(string $id): SoldTicket;
    public function getSoldTicketsByUserID(string $userID): array;
    public function getTicketsByCartID(string $cartID): array;
    public function addTicketToCart(string $ticketID, string $cartID): void;
    public function getCartByUserID(string $userID): Cart;
    public function getCartByID(string $cartID): Cart;
    public function saveCart(Cart $cart): string;
    public function getTicketsByPartyID(string $partyId): array;
    public function getNbSoldTicketsByPartyID(string $partyId): int;
    public function updateTicketQuantity(string $cartID, string $ticketID, int $quantity): Cart;
    public function deleteTicketFromCart(string $cartID, string $ticketID): Cart;
}