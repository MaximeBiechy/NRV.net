<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceBadDataException;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\party\PartyServiceInternalServerErrorException;
use nrv\core\services\party\PartyServiceNotFoundException;
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

class DisplayPartyGaugeAction extends AbstractAction
{

    private PartyServiceInterface $partyService;
    private TicketServiceInterface $ticketService;

    public function __construct(PartyServiceInterface $partyService, TicketServiceInterface $ticketService)
    {
        $this->partyService = $partyService;
        $this->ticketService = $ticketService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {

            // Vérification de l'ID UUID
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($args['ID-PARTY'])) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }
            $party = $this->partyService->getParty($args['ID-PARTY']);
            $soldTickets = $this->ticketService->getNbSoldTicketsByPartyId($args['ID-PARTY']);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $images = $party->place->images;
            $images = array_map(function ($image) use ($routeParser) {
                return [
                    "self" => ['href' => $image]
                ];
            }, $images);
            $party = [
                "id" => $party->id,
                "name" => $party->name,
                "begin" => $party->begin,
                "place" => [
                    "id" => $party->place->id,
                    "name" => $party->place->name,
                    "address" => $party->place->address,
                    "images" => $images,
                    "links" => [
                        "self" => ['href' => $routeParser->urlFor('places_id', ['ID-PLACE' => $party->place->id])]
                    ]
                ],
                "spectator_gauge" => $soldTickets,
                "links" => [
                    "self" => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $party->id])]
                ]
            ];

            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                'party' => $party,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $party['id']])]
                ]
            ];

            return JsonRenderer::render($rs, 200, $response);
        } catch (PartyServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (TicketServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (PartyServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (TicketBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (PartyServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}