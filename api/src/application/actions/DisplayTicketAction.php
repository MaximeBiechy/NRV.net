<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayTicketAction extends AbstractAction
{
    private TicketServiceInterface $ticketServiceInterface;

    public function __construct(TicketServiceInterface $ticketServiceInterface)
    {
        $this->ticketServiceInterface = $ticketServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $ticket = $this->ticketServiceInterface->getTicket($args['ID-TICKET']);
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            'ticket' => [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'quantity' => $ticket->quantity,
                'party_id' => $ticket->party_id,
                'price' => $ticket->price,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('tickets_id', ['ID-TICKET' => $ticket->id])],
                    'party' => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $ticket->party_id])]
                ]
            ],
            'links' => [
                'self' => ['href' => $routeParser->urlFor('tickets_id', ['ID-TICKET' => $ticket->id])]
            ]
        ];

        return JsonRenderer::render($rs,200 ,$response);
    }
}