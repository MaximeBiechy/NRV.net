<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;

class PDOTicketRepository implements TicketRepositoryInterface
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Ticket $ticket): string
    {
        // TODO: Implement save() method.
    }

    public function getTicketsByUserID(string $userID): array
    {
        // TODO: Implement getTicketsByUserID() method.
    }

    public function getTicketById(string $id): Ticket
    {
        // TODO: Implement getTicketById() method.
    }
}