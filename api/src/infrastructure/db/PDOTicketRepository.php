<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\card\Card;
use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use Ramsey\Uuid\Uuid;

class PDOTicketRepository implements TicketRepositoryInterface
{
    private $pdo_ticket;

    public function __construct($pdo)
    {
        $this->pdo_ticket = $pdo;
    }

    public function saveTicket(Ticket $ticket): string
    {
        try {
            if ($ticket->getID() !== null) {
                $stmt = $this->pdo_ticket->prepare("UPDATE tickets SET name = :name, price = :price, quantity = :quantity, party_id = :party_id WHERE id = :id");
            } else {
                $id = Uuid::uuid4()->toString();
                $ticket->setID($id);
                $stmt = $this->pdo_ticket->prepare("INSERT INTO tickets (id, name, price, quantity, party_id) VALUES (:id, :name, :price, :quantity, :party_id)");
            }
            $stmt->execute([
                'id' => $ticket->getID(),
                'name' => $ticket->getName(),
                'price' => $ticket->getPrice(),
                'quantity' => $ticket->getQuantity(),
                'party_id' => $ticket->getPartyID()
            ]);
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error saving ticket");
        }

        return $ticket->getID();
    }

    public function saveSoldTicket(SoldTicket $soldTicket): string
    {
        try {
            if ($soldTicket->getID() !== null) {
                $stmt = $this->pdo_ticket->prepare("UPDATE soldtickets SET name = :name, price = :price, ticket_id = :ticket_id, user_id = :user_id, party_id = :party_id WHERE id = :id");
            } else {
                $id = Uuid::uuid4()->toString();
                $soldTicket->setID($id);
                $stmt = $this->pdo_ticket->prepare("INSERT INTO soldtickets (id, name, price, ticket_id, user_id, party_id) VALUES (:id, :name, :price, :ticket_id, :user_id, :party_id,)");
            }
            $stmt->execute([
                'id' => $soldTicket->getID(),
                'name' => $soldTicket->getName(),
                'price' => $soldTicket->getPrice(),
                'ticket_id' => $soldTicket->getTicketID(),
                'user_id' => $soldTicket->getUserID(),
                'party_id' => $soldTicket->getPartyID()
            ]);
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error saving sold ticket");
        }

        return $soldTicket->getID();
    }

    public function getTicketById(string $id): Ticket
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM tickets WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $ticket = $stmt->fetch();
            if ($ticket === false) {
                throw new RepositoryInternalServerError("Ticket not found");
            }
            $t = new Ticket($ticket['name'], $ticket['price'], $ticket['quantity'], $ticket['party_id']);
            $t->setID($ticket['id']);
            return $t;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting ticket");
        }
    }

    public function getSoldTicketById(string $id): SoldTicket
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM soldtickets WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $soldTicket = $stmt->fetch();
            if ($soldTicket === false) {
                throw new RepositoryInternalServerError("Sold ticket not found");
            }
            $t = new SoldTicket($soldTicket['name'], $soldTicket['price'], $soldTicket['ticket_id'], $soldTicket['user_id'], $soldTicket['party_id']);
            $t->setID($soldTicket['id']);
            return $t;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting sold ticket");
        }
    }

    public function getSoldTicketsByUserID(string $userID): array
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM soldtickets WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userID]);
            $tickets = $stmt->fetchAll();
            $ts = [];
            foreach ($tickets as $ticket) {
                $t = new SoldTicket($ticket['name'], $ticket['price'], $ticket['ticket_id'], $ticket['user_id'], $ticket['party_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting sold tickets by user id");
        }
    }

    public function getTicketsByCardID(string $cardID): array
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM tickets INNER JOIN card_content ON tickets.id = card_content.ticket_id WHERE card_content.card_id = :card_id");
            $stmt->execute(['card_id' => $cardID]);
            $tickets = $stmt->fetchAll();
            $ts = [];
            foreach ($tickets as $ticket) {
                $t = new Ticket($ticket['name'], $ticket['price'], $ticket['quantity'], $ticket['party_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting tickets by card id");
        }
    }

    public function addTicketToCard(string $ticketID, string $cardID): void
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM card_content WHERE card_id = :card_id AND ticket_id = :ticket_id");
            $stmt->execute(['card_id' => $cardID, 'ticket_id' => $ticketID]);
            $ticket = $stmt->fetch();
            if ($ticket !== false) {
                $stmt2 = $this->pdo_ticket->prepare("UPDATE card_content SET quantity = quantity + 1 WHERE card_id = :card_id AND ticket_id = :ticket_id");
            } else {
                $stmt2 = $this->pdo_ticket->prepare("INSERT INTO card_content (card_id, ticket_id, quantity) VALUES (:card_id, :ticket_id, 1)");
            }
            $stmt2->execute(['card_id' => $cardID, 'ticket_id' => $ticketID]);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error adding ticket to card");
        }
    }

    public function getCardByUserID(string $userID): Card
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM cards WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userID]);
            $card = $stmt->fetch();
            if ($card === false) {
                throw new RepositoryInternalServerError("Card not found");
            }
            try {
                $tickets = $this->getTicketsByCardID($card['id']);
            } catch (RepositoryInternalServerError $e) {
                throw new RepositoryInternalServerError($e->getMessage());
            }
            $c = new Card($card['user_id'], $card['total_price'], $tickets);
            $c->setID($card['id']);
            return $c;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting card by user id");
        }
    }
}