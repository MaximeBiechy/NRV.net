<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\card\AddTicketToCardDTO;
use nrv\core\services\ticket\TicketServiceInterface;
use nrv\core\services\ticket\TicketServiceInternalServerErrorException;
use nrv\core\services\ticket\TicketServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class AddTicketToUserCardAction extends AbstractAction
{
    private TicketServiceInterface $ticketService;

    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $card_id = $args['ID-CARD'];
        $ticket_id = $rq->getParsedBody()['ticket_id'];

        try {
            $this->ticketService->addTicketToCard(new AddTicketToCardDTO($card_id, $ticket_id));
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "message" => "Ticket added to card",
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (TicketServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}