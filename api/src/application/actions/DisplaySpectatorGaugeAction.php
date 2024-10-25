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
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplaySpectatorGaugeAction extends AbstractAction
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
            $parties = $this->partyService->getParties();
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $parties = array_map(function ($party) use ($routeParser) {
                $soldTickets = $this->ticketService->getNbSoldTicketsByPartyId($party->id);
                $images = $party->place->images;
                $images = array_map(function ($image) use ($routeParser) {
                    return [
                        "self" => ['href' => $image]
                    ];
                }, $images);
                return [
                    "party_id" => $party->id,
                    "party_title" => $party->name,
                    "party_date" => $party->begin,
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
            }, $parties);

            $response = [
                "type" => "collection",
                "locale" => "fr-FR",
                "parties" => $parties
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
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (PartyServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}