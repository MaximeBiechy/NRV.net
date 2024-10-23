<?php

namespace nrv\core\services\ticket;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\dto\cart\AddTicketToCartDTO;
use nrv\core\dto\cart\CartDTO;
use nrv\core\dto\ticket\CreateTicketDTO;
use nrv\core\dto\ticket\SoldTicketDTO;
use nrv\core\dto\ticket\TicketDTO;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use nrv\core\services\ticket\TicketServiceInterface;

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

    public function validateCommand(string $cardId): CartDTO
    {
        try{
            $cart = $this->ticketRepository->getCartByID($cardId);
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
            $cart = $this->ticketRepository->getCartByID($cartId);
            if ($cart->getState() >= 3) {
                throw new TicketBadDataException("Cart already payed");
            }
            if ($cart->getState() < 2) {
                throw new TicketBadDataException("Cart not validated");
            }
            $cart->setState(3);
            $this->ticketRepository->saveCart($cart);
            $t = [];
            foreach ($cart->getTickets() as $ticket) {
                $t[] = new TicketDTO($ticket);
            }
            $cart->setTickets($t);
            $this->ticketRepository->saveCart(new Cart($cart->getUserId(), 0, []));
            return new CartDTO($cart);
        } catch (RepositoryInternalServerError $e) {
            throw new TicketServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new TicketServiceNotFoundException($e->getMessage());
        }
    }
}