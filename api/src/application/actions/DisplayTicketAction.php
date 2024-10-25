<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketBadDataException;
use nrv\core\services\ticket\TicketServiceInterface;
use nrv\core\services\ticket\TicketServiceInternalServerErrorException;
use nrv\core\services\ticket\TicketServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Rfc4122\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
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
        try {
            // Vérification de l'ID UUID
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($args['ID-TICKET'])) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }
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