<?php

namespace nrv\core\services\ticket;

use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;

class AuthzTicketService implements AuthzTicketServiceInterface
{
    private TicketRepositoryInterface $ticketRepository;
    private AuthRepositoryInterface $authRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository, AuthRepositoryInterface $authRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->authRepository = $authRepository;
    }


    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool
    {
        switch ($operation){
            case ADD_TICKET_TO_CART:
                $cart = $this->ticketRepository->getCartByUserId($user_id);
                return $cart->getUserId() === $user_id && $cart->getID() === $ressource_id;
            case CREATE_TICKET :
                return $role === ADMIN || $role === SUPER_ADMIN;
            case CONSULTING_CART :
                $cart = $this->ticketRepository->getCartByUserId($user_id);
                return $cart->getUserId() === $user_id;
            case CONSULTING_SOLD_TICKET :
                return $user_id === $ressource_id;
            default :
                return true;

        }
    }
}