<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplaySoldTicketsByUserAction extends AbstractAction
{

    private TicketServiceInterface $ticketService;

    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user_id = $args['ID-USER'];
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();

        $soldTickets = $this->ticketService->getSoldTicketsByUserId($user_id);
        $soldTickets = array_map(function($soldTicket) use ($routeParser) {
            $urlSoldTicket = $routeParser->urlFor('users_id_sold_tickets', ['ID-USER' => $soldTicket->user_id]);
            return [
                "id" => $soldTicket->id,
                "price" => $soldTicket->price,
                "user_id" => $soldTicket->user_id,
                "ticket_id" => $soldTicket->ticket_id,
                "party_id" => $soldTicket->party_id,
                "links" => [
                    "self" => ['href' => $urlSoldTicket],
                    "party" => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $soldTicket->party_id])],
                ]
            ];
        }, $soldTickets);

        $response = [
            "type" => "collection",
            "locale" => "fr-FR",
            "sold_tickets" => $soldTickets,
        ];

        return JsonRenderer::render($rs, 200, $response);
    }
}