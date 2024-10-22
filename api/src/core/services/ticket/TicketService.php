<?php

namespace nrv\core\services\ticket;

use nrv\core\dto\ticket\CreateTicketDTO;
use nrv\core\dto\ticket\TicketDTO;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use nrv\core\services\ticket\TicketServiceInterface;

class TicketService implements TicketServiceInterface
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getTicketsByUserID(string $userID): array
    {
        // TODO: Implement getTicketsByUserID() method.
    }

    public function getTicketById(string $id): TicketDTO
    {
        // TODO: Implement getTicketById() method.
    }

    public function createTicket(CreateTicketDTO $ticket): TicketDTO
    {
        // TODO: Implement createTicket() method.
    }
}