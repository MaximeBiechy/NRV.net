<?php

namespace nrv\infrastructure\db;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
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
        } catch (\PDOException $e) {
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
                $stmt = $this->pdo_ticket->prepare("INSERT INTO soldtickets (id, name, price, user_id, ticket_id, party_id) VALUES (:id, :name, :price, :user_id, :ticket_id, :party_id)");
            }
            $stmt->execute([
                'id' => $soldTicket->getID(),
                'name' => $soldTicket->getName(),
                'price' => $soldTicket->getPrice(),
                'ticket_id' => $soldTicket->getTicketID(),
                'user_id' => $soldTicket->getUserID(),
                'party_id' => $soldTicket->getPartyID()
            ]);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error saving sold ticket" . $e->getMessage());
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
                throw new RepositoryEntityNotFoundException("Ticket not found");
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
                $t = new SoldTicket($ticket['name'], $ticket['price'], $ticket['user_id'], $ticket['party_id'], $ticket['ticket_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting sold tickets by user id");
        }
    }

    public function getTicketsByCartID(string $cartID): array
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM tickets INNER JOIN cart_content ON tickets.id = cart_content.ticket_id WHERE cart_content.cart_id = :cart_id");
            $stmt->execute(['cart_id' => $cartID]);
            $tickets = $stmt->fetchAll();
            $ts = [];
            foreach ($tickets as $ticket) {
                $t = new Ticket($ticket['name'], $ticket['price'], $ticket['quantity'], $ticket['party_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting tickets by cart id");
        }
    }

    public function addTicketToCart(string $ticketID, string $cartID): void
    {
        try {
            // Vérifie que l'état du panier est 0
            $stmt0 = $this->pdo_ticket->prepare("SELECT state FROM carts WHERE id = :cart_id");
            $stmt0->execute(['cart_id' => $cartID]);
            $state = $stmt0->fetch();
            if ($state === false || $state['state'] != 0) {
                throw new RepositoryEntityNotFoundException("Cart not found or state is not 0");
            }

            // Vérifie qu'il y a assez de tickets
            $stmt1 = $this->pdo_ticket->prepare("SELECT quantity FROM tickets WHERE id = :ticket_id");
            $stmt1->execute(['ticket_id' => $ticketID]);
            $result1 = $stmt1->fetch();
            $quantity = $result1 ? $result1['quantity'] : 0;

            $stmt2 = $this->pdo_ticket->prepare("SELECT quantity FROM cart_content WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt2->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);
            $result2 = $stmt2->fetch();
            $quantity_card_content = $result2 ? $result2['quantity'] : 0;

            if ($quantity <= $quantity_card_content) {
                throw new RepositoryInternalServerError("Not enough tickets");
            }

            $stmt3 = $this->pdo_ticket->prepare("SELECT * FROM cart_content WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt3->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);
            $ticket = $stmt3->fetch();
            if ($ticket !== false) {
                $stmt4 = $this->pdo_ticket->prepare("UPDATE cart_content SET quantity = quantity + 1 WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            } else {
                $stmt4 = $this->pdo_ticket->prepare("INSERT INTO cart_content (cart_id, ticket_id, quantity) VALUES (:cart_id, :ticket_id, 1)");
            }
            $stmt4->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);

            // Modification du prix
            $stmt5 = $this->pdo_ticket->prepare("UPDATE carts SET total_price = total_price + (SELECT price FROM tickets WHERE id = :ticket_id) WHERE id = :cart_id");
            $stmt5->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error adding ticket to cart");
        }
    }

    public function getCartByUserID(string $userID): Cart
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM carts WHERE user_id = :user_id and state != 3");
            $stmt->execute(['user_id' => $userID]);
            $cart = $stmt->fetch();
            if ($cart === false) {
                throw new RepositoryEntityNotFoundException("Cart not found");
            }
            try {
                $tickets = $this->getTicketsByCartID($cart['id']);
            } catch (RepositoryInternalServerError $e) {
                throw new RepositoryInternalServerError($e->getMessage());
            }
            $c = new Cart($cart['user_id'], $cart['total_price'], $tickets);
            $c->setID($cart['id']);
            return $c;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting cart by user id");
        }
    }

    public function getCartByID(string $cartID): Cart
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM carts WHERE id = :id");
            $stmt->execute(['id' => $cartID]);
            $cart = $stmt->fetch();
            if ($cart === false) {
                throw new RepositoryEntityNotFoundException("Cart not found");
            }
            try {
                $tickets = $this->getTicketsByCartID($cart['id']);
            } catch (RepositoryInternalServerError $e) {
                throw new RepositoryInternalServerError($e->getMessage());
            }
            $c = new Cart($cart['user_id'], $cart['total_price'], $tickets, $cart['state']);
            $c->setID($cart['id']);
            return $c;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting cart by id");
        }
    }

    public function saveCart(Cart $cart): string
    {
        try {
            if ($cart->getID() !== null) {
                $stmt = $this->pdo_ticket->prepare("UPDATE carts SET user_id = :user_id, total_price = :total_price, state = :state WHERE id = :id");
            } else {
                $id = Uuid::uuid4()->toString();
                $cart->setID($id);
                $stmt = $this->pdo_ticket->prepare("INSERT INTO carts (id, user_id, total_price, state) VALUES (:id, :user_id, :total_price, :state)");
            }
            $stmt->execute([
                'id' => $cart->getID(),
                'user_id' => $cart->getUserID(),
                'total_price' => $cart->getTotalPrice(),
                'state' => $cart->getState()
            ]);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error saving cart");
        }

        return $cart->getID();
    }

    public function getTicketsByPartyID(string $partyId): array
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM tickets WHERE party_id = :party_id");
            $stmt->execute(['party_id' => $partyId]);
            $tickets = $stmt->fetchAll();
            $ts = [];
            foreach ($tickets as $ticket) {
                $t = new Ticket($ticket['name'], $ticket['price'], $ticket['quantity'], $ticket['party_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting tickets by party id");
        }
    }

    public function getNbSoldTicketsByPartyID(string $partyId): int
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT COUNT(*) FROM soldtickets WHERE party_id = :party_id");
            $stmt->execute(['party_id' => $partyId]);
            $nb = $stmt->fetch() ?? [0];
            return $nb[0];
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting number of sold tickets by party id");
        }
    }


    public function updateTicketQuantity(string $cartID, string $ticketID, int $quantity): Cart
    {
        try {
            // Vérifie que l'état du panier est 0
            $stmt0 = $this->pdo_ticket->prepare("SELECT state FROM carts WHERE id = :cart_id");
            $stmt0->execute(['cart_id' => $cartID]);
            $state = $stmt0->fetch();
            if ($state === false || $state['state'] != 0) {
                throw new RepositoryInternalServerError("Cart not found or state is not 0");
            }
            // Vérifie que le ticket est dans le panier
            $stmt1 = $this->pdo_ticket->prepare("SELECT * FROM cart_content WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt1->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);
            if ($stmt1->fetch() === false) {
                throw new RepositoryEntityNotFoundException("Ticket not found in cart");
            }

            // Mise à jour de la quantité
            $stmt2 = $this->pdo_ticket->prepare("UPDATE cart_content SET quantity = :quantity WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt2->execute(['quantity' => $quantity, 'cart_id' => $cartID, 'ticket_id' => $ticketID]);

            // Mise à jour du prix
            $stmt3 = $this->pdo_ticket->prepare("
            UPDATE carts 
            SET total_price = (
                SELECT SUM(tickets.price * cart_content.quantity)
                FROM cart_content
                INNER JOIN tickets ON cart_content.ticket_id = tickets.id
                WHERE cart_content.cart_id = :cart_id
            ) 
            WHERE carts.id = :cart_id
            ");
            $stmt3->execute(['cart_id' => $cartID]);

            return $this->getCartByID($cartID);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error updating ticket quantity" . $e->getMessage());
        }
    }

    public function deleteTicketFromCart(string $cartID, string $ticketID): Cart
    {
        try {
            // Vérifie que l'état du panier est 0
            $stmt0 = $this->pdo_ticket->prepare("SELECT state FROM carts WHERE id = :cart_id");
            $stmt0->execute(['cart_id' => $cartID]);
            $state = $stmt0->fetch();
            if ($state === false || $state['state'] != 0) {
                throw new RepositoryEntityNotFoundException("Cart not found or state is not 0");
            }
            // Vérifie que le ticket est dans le panier
            $stmt1 = $this->pdo_ticket->prepare("SELECT * FROM cart_content WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt1->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);
            if ($stmt1->fetch() === false) {
                throw new RepositoryEntityNotFoundException("Ticket not found in cart");
            }
            $stmt2 = $this->pdo_ticket->prepare("DELETE FROM cart_content WHERE cart_id = :cart_id AND ticket_id = :ticket_id");
            $stmt2->execute(['cart_id' => $cartID, 'ticket_id' => $ticketID]);

            $stmt3 = $this->pdo_ticket->prepare("
                UPDATE carts 
                SET total_price = COALESCE((
                    SELECT SUM(t.price * cc.quantity)
                    FROM cart_content cc
                    INNER JOIN tickets t ON cc.ticket_id = t.id
                    WHERE cc.cart_id = :cart_id
                ), 0)
                WHERE id = :cart_id
            ");
            $stmt3->execute(['cart_id' => $cartID]);

            return $this->getCartByID($cartID);
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error deleting ticket from cart " . $e->getMessage());
        }
    }

    public function getTickets(): array
    {
        try {
            $stmt = $this->pdo_ticket->prepare("SELECT * FROM tickets");
            $stmt->execute();
            $tickets = $stmt->fetchAll();
            $ts = [];
            foreach ($tickets as $ticket) {
                $t = new Ticket($ticket['name'], $ticket['price'], $ticket['quantity'], $ticket['party_id']);
                $t->setID($ticket['id']);
                $ts[] = $t;
            }
            return $ts;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error getting tickets");
        }
    }
}