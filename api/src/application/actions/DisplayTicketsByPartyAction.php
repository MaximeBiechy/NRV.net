<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayTicketsByPartyAction extends AbstractAction
{

    private TicketServiceInterface $ticketService;
    private PartyServiceInterface $partyService;

    public function __construct(TicketServiceInterface $ticketService, PartyServiceInterface $partyService)
    {
        $this->ticketService = $ticketService;
        $this->partyService = $partyService;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $party = $this->partyService->getParty($args['ID-PARTY']);
        $tickets = $this->ticketService->getTicketsByPartyId($args['ID-PARTY']);
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $place = $party->place;
        $place = [
            'id' => $place->id,
            'name' => $place->name,
            'address' => $place->address,
            'nbSit' => $place->nbSit,
            'nbStand' => $place->nbStand,
            'images' => [
                'self' => ['href'=> $place->images]
            ],
            'links' => [
                'self' => ['href' => $routeParser->urlFor('places_id', ['ID-PLACE' => $place->id])]
            ]
        ];
        $shows = $party->shows;


        $shows = array_map(function($show) use ($routeParser) {
            $artists = $show->artists;
            $artists = array_map(function($artist) use ($routeParser) {
                return [
                    'id' => $artist->id,
                    'name' => $artist->name,
                    'style' => $artist->style,
                    'image' => [
                        'self' => ['href' => $artist->image]
                    ],
                    'links' => [
                        'self' => ['href' => $routeParser->urlFor('artists_id', ['ID-ARTIST' => $artist->id])]
                    ]
                ];
            }, $artists);
            return [
                'id' => $show->id,
                'title' => $show->title,
                'description' => $show->description,
                'video' => $show->video,
                'images' => [
                    'self' => ['href' => $show->images]
                ],
                'artists' => $artists,
                'begin' => $show->begin,
                'links' => [
                    'self' => ['href' => $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id])]
                ]
            ];
        }, $shows);
        $party = [
            'id' => $party->id,
            'name' => $party->name,
            'theme' => $party->theme,
            'price' => $party->price,
            'date' => $party->date,
            'begin' => $party->begin,
            'place' => $place,
            'shows' => $shows,
            'tickets' => $tickets
        ];
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            'party' => $party,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('parties_id_tickets', ['ID-PARTY' => $party['id']])]
            ]
        ];
        return JsonRenderer::render($rs, 200, $response);

    }
}