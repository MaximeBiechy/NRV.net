<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayCartAction extends AbstractAction
{
    private TicketServiceInterface $ticketServiceInterface;

    public function __construct(TicketServiceInterface $ticketServiceInterface)
    {
        $this->ticketServiceInterface = $ticketServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user_id = $args['ID-USER'];
        $cart = $this->ticketServiceInterface->getCartByUserId($user_id);
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('users_id_cart', ['ID-USER' => $user_id]);
        $tickets = $cart->tickets;
        $tickets = array_map(function($ticket) use ($routeParser) {
            $urlSelf = $routeParser->urlFor('tickets_id', ['ID-TICKET' => $ticket->id]);
            return [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'quantity' => $ticket->quantity,
                'party_id' => $ticket->party_id,
                'price' => $ticket->price,
                'links' => [
                    'self' => ['href' => $urlSelf],
                    'party' => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $ticket->party_id])]
                ]
            ];
        }, $tickets);
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            "cart" => [
                "id" => $cart->id,
                "user_id" => $cart->user_id,
                "state" => $cart->state,
                "tickets" => $tickets,
                "links" => [
                    "self" => ['href' => $urlSelf],
                    'add_ticket' => ['href' => $routeParser->urlFor('carts_id', ['ID-CART' => $cart->id])],
                    'update_cart' => ['href' => $routeParser->urlFor('update_card_id', ['ID-CART' => $cart->id])]
                ]
            ]
        ];
        return JsonRenderer::render($rs,200, $response);


    }
}