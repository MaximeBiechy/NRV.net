<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\cart\AddTicketToCartDTO;
use nrv\core\services\ticket\TicketBadDataException;
use nrv\core\services\ticket\TicketServiceInterface;
use nrv\core\services\ticket\TicketServiceInternalServerErrorException;
use nrv\core\services\ticket\TicketServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class AddTicketToUserCartAction extends AbstractAction
{
    private TicketServiceInterface $ticketService;

    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $uuidValidator = new \Ramsey\Uuid\Rfc4122\Validator();
        $card_id = $args['ID-CART'];
        if (!$uuidValidator->validate($card_id)) {
            throw new HttpBadRequestException($rq, "Invalid UUID format. Cart ID");
        }
        $ticket_id = $rq->getParsedBody()['ticket_id'];
        if (!$uuidValidator->validate($ticket_id)) {
            throw new HttpBadRequestException($rq, "Invalid UUID format. Ticket ID");
        }

        try {
            $this->ticketService->addTicketToCart(new AddTicketToCartDTO($card_id, $ticket_id));
            $cart = $this->ticketService->getCart($card_id);
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "cart" => $cart
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (TicketServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (TicketBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}