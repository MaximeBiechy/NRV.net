<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\auth\AuthentificationServiceBadDataException;
use nrv\core\services\auth\AuthentificationServiceInterface;
use nrv\core\services\auth\AuthentificationServiceInternalServerErrorException;
use nrv\core\services\auth\AuthentificationServiceNotFoundException;
use nrv\core\services\party\PartyServiceInterface;
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

class DisplaySoldTicketsByUserAction extends AbstractAction
{

    private TicketServiceInterface $ticketService;
    private AuthentificationServiceInterface $authentificationService;


    public function __construct(TicketServiceInterface $ticketService, AuthentificationServiceInterface $authentificationService)
    {
        $this->ticketService = $ticketService;
        $this->authentificationService = $authentificationService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $user_id = $args['ID-USER'];
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($user_id)) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }
            $this->authentificationService->getUserById($user_id);

            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $soldTickets = $this->ticketService->getSoldTicketsByUserId($user_id);
            $soldTickets = array_map(function ($soldTicket) use ($routeParser) {
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
        } catch (TicketServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (TicketBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (AuthentificationServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (AuthentificationServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (AuthentificationServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}