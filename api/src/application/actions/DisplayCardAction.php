<?php

namespace nrv\application\actions;

use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DisplayCardAction extends AbstractAction
{
    private TicketServiceInterface $ticketServiceInterface;

    public function __construct(TicketServiceInterface $ticketServiceInterface)
    {
        $this->ticketServiceInterface = $ticketServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user_id = $args['ID-USER'];
        $card = $this->ticketServiceInterface->getCardByUserId($user_id);


    }
}