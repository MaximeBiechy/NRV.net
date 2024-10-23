<?php

namespace nrv\core\services\ticket;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\dto\cart\AddTicketToCartDTO;
use nrv\core\dto\cart\CartDTO;
use nrv\core\dto\ticket\SoldTicketDTO;
use nrv\core\dto\ticket\TicketDTO;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;

class TicketService implements TicketServiceInterface
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function addTicketToCart(AddTicketToCartDTO $dto): void
    {
        try{
            $this->ticketRepository->addTicketToCart($dto->ticket_id, $dto->card_id);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }

    }


    public function getTicketsFromCart(string $id): array
    {
        try{
            $tickets = $this->ticketRepository->getTicketsByCartID($id);
            $ticketDTOs = [];
            foreach ($tickets as $ticket) {
                $ticketDTOs[] = new TicketDTO($ticket);
            }
            return $ticketDTOs;
        }catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function createTicket(TicketDTO $ticketDTO): TicketDTO
    {
        try{
            $ticket = new Ticket($ticketDTO->name, $ticketDTO->price, $ticketDTO->quantity, $ticketDTO->party_id);
            $ticketId = $this->ticketRepository->saveTicket($ticket);
            $ticket->setId($ticketId);
            return new TicketDTO($ticket);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        }
    }

    public function getTicket(string $ticketId): TicketDTO
    {
        try{
            $ticket = $this->ticketRepository->getTicketById($ticketId);
            return new TicketDTO($ticket);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }


    public function createSoldTicket(SoldTicketDTO $ticketDTO): SoldTicketDTO
    {
        try{
            $soldTicket = new SoldTicket($ticketDTO->name, $ticketDTO->price, $ticketDTO->user_id, $ticketDTO->party_id, $ticketDTO->ticket_id);
            $soldTicketId = $this->ticketRepository->saveSoldTicket($soldTicket);
            $soldTicket->setId($soldTicketId);
            return new SoldTicketDTO($soldTicket);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        }
    }

    public function getSoldTicket(string $ticketId): SoldTicketDTO
    {
        try{
            $soldTicket = $this->ticketRepository->getSoldTicketById($ticketId);
            return new SoldTicketDTO($soldTicket);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function getCartByUserId(string $userId): CartDTO
    {
        try{
            $cart = $this->ticketRepository->getCartByUserID($userId);
            $t = [];
            foreach ($cart->getTickets() as $ticket) {
                $t[] = new TicketDTO($ticket);
            }
            $cart->setTickets($t);
            return new CartDTO($cart);
        }catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function validateCart(string $cartId): CartDTO
    {
        try{
            $card = $this->ticketRepository->getCartByID($cartId);
            if ($card->getState() >= 1) {
                throw new TicketBadDataException("Cart already validated");
            }
            if ($card->getState() < 0) {
                throw new TicketBadDataException("Cart not validated");
            }
            $card->setState(1);
            $this->ticketRepository->saveCart($card);
            $t = [];
            foreach ($card->getTickets() as $ticket) {
                $t[] = new TicketDTO($ticket);
            }
            $card->setTickets($t);
            return new CartDTO($card);
        }catch (RepositoryInternalServerError $e) {
            throw new TicketServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new TicketServiceNotFoundException($e->getMessage());
        }
    }

    public function validateCommand(string $cartId): CartDTO
    {
        try{
            $cart = $this->ticketRepository->getCartByID($cartId);
            if ($cart->getState() >= 2) {
                throw new TicketBadDataException("Cart already validated");
            }
            if ($cart->getState() < 1) {
                throw new TicketBadDataException("Cart not validated");
            }
            $cart->setState(2);
            $this->ticketRepository->saveCart($cart);
            $t = [];
            foreach ($cart->getTickets() as $ticket) {
                $t[] = new TicketDTO($ticket);
            }
            $cart->setTickets($t);
            return new CartDTO($cart);
        }catch (RepositoryInternalServerError $e) {
            throw new TicketServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new TicketServiceNotFoundException($e->getMessage());
        }
    }

    public function payCart(string $cartId): CartDTO
    {
        try {
            // Récupérer et valider le panier
            $cart = $this->ticketRepository->getCartByID($cartId);

            if ($cart->getState() >= 3) {
                throw new TicketBadDataException("Cart already paid");
            }
            if ($cart->getState() < 2) {
                throw new TicketBadDataException("Cart not validated");
            }

            // Traiter les tickets du panier
            $updatedTickets = $this->processTickets($cart->getTickets(), $cart->getUserId());

            // Mettre à jour l'état du panier
            $cart->setState(3);
            $cart->setTickets($updatedTickets);
            $this->ticketRepository->saveCart($cart);
            $this->ticketRepository->saveCart(new Cart($cart->getUserId(), 0, []));
            // Retourner le panier mis à jour sous forme de DTO
            return new CartDTO($cart);
        } catch (RepositoryInternalServerError $e) {
            throw new TicketServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new TicketServiceNotFoundException($e->getMessage());
        } catch (TicketBadDataException $e) {
            throw new TicketBadDataException($e->getMessage());
        }
    }

    /**
     * Traiter les tickets du panier en les validant et en les vendant si possible
     * @param array $tickets Liste des tickets à traiter
     * @return array Liste des tickets mis à jour
     * @throws TicketBadDataException
     */
    private function processTickets(array $tickets, string $user_id): array
    {
        $updatedTickets = [];

        foreach ($tickets as $ticket) {
            // Vérifier et décrémenter les quantités de billets disponibles
            $this->validateAndDecrementTickets($ticket);

            // Sauvegarder le billet vendu
            $soldTicket = new SoldTicket($ticket->getName(), $ticket->getPrice(), $user_id, $ticket->getPartyId(), $ticket->getId());
            $this->ticketRepository->saveSoldTicket($soldTicket);

            // Ajouter le ticket mis à jour dans la liste
            $updatedTickets[] = new TicketDTO($ticket);
        }

        return $updatedTickets;
    }

    /**
     * Vérifier et décrémenter les quantités de billets disponibles
     * @param Ticket $ticket Billet à valider
     * @return void
     * @throws TicketBadDataException
     */
    private function validateAndDecrementTickets(Ticket $ticket): void
    {
        $availableTickets = $this->ticketRepository->getTicketsByPartyID($ticket->getPartyId());

        foreach ($availableTickets as $availableTicket) {
            if ($availableTicket->getQuantity() <= 0) {
                throw new TicketBadDataException("No more tickets available for this party");
            }
        }

        // Décrémenter la quantité des tickets disponibles
        foreach ($availableTickets as $availableTicket) {
            if ($availableTicket->getQuantity() > 0) {
                $availableTicket->setQuantity($availableTicket->getQuantity() - 1);
                $this->ticketRepository->saveTicket($availableTicket);
            }
        }
    }

    public function getTicketsByPartyId(string $partyId): array
    {
        try{
            $tickets = $this->ticketRepository->getTicketsByPartyID($partyId);
            $ticketDTOs = [];
            foreach ($tickets as $ticket) {
                $ticketDTOs[] = new TicketDTO($ticket);
            }
            return $ticketDTOs;
        }catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function getSoldTicketsByUserId(string $userId): array
    {
        try{
            $soldTickets = $this->ticketRepository->getSoldTicketsByUserID($userId);
            $soldTicketDTOs = [];
            foreach ($soldTickets as $soldTicket) {
                $soldTicketDTOs[] = new SoldTicketDTO($soldTicket);
            }
            return $soldTicketDTOs;
        }catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function getNbSoldTicketsByPartyId(string $partyId): int
    {
        try{
            return $this->ticketRepository->getNbSoldTicketsByPartyID($partyId);
        }catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }
}