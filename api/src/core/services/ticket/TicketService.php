<?php

namespace nrv\core\services\ticket;

use nrv\core\domain\entities\ticket\SoldTicket;
use nrv\core\domain\entities\ticket\Ticket;
use nrv\core\dto\card\AddTicketToCardDTO;
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

    public function addTicketToCard(AddTicketToCardDTO $dto): void
    {
        try{
            $this->ticketRepository->addTicketToCard($dto->card_id, $dto->ticket_id);
        } catch (RepositoryInternalServerError $e) {
            throw new RepositoryInternalServerError($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }

    }


    public function getTicketsFromCard(string $id): array
    {
        try{
            $tickets = $this->ticketRepository->getTicketsByCardID($id);
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
}