<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayTicketsAction extends AbstractAction
{
    private TicketServiceInterface $ticketServiceInterface;

    public function __construct(TicketServiceInterface $ticketServiceInterface)
    {
        $this->ticketServiceInterface = $ticketServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $tickets = $this->ticketServiceInterface->getTickets();
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $tickets = array_map(function($ticket) use ($routeParser) {
            return [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'quantity' => $ticket->quantity,
                'party_id' => $ticket->party_id,
                'price' => $ticket->price,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('tickets_id', ['ID-TICKET' => $ticket->id])],
                    'party' => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $ticket->party_id])]
                ]
            ];
        }, $tickets);
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            'tickets' => $tickets,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('tickets')]
            ]
        ];
        return JsonRenderer::render($rs,200 ,$response);
    }
}