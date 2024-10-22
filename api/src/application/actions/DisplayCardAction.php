<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

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
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('users_id_card', ['ID-USER' => $user_id]);
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            "card" => [
                "id" => $card->id,
                "user_id" => $card->user_id,
                "tickets" => $card->tickets,
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ]
        ];
        return JsonRenderer::render($rs,200, $response);


    }
}