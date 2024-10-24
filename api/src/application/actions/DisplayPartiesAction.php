<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\show\ShowServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayPartiesAction extends AbstractAction
{

    private PartyServiceInterface $partyService;
    private ShowServiceInterface $showService;

    public function __construct(PartyServiceInterface $partyService, ShowServiceInterface $showService)
    {
        $this->partyService = $partyService;
        $this->showService = $showService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $parties = $this->partyService->getParties();

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $parties = array_map(function($party) use ($routeParser) {
            $urlSelf = $routeParser->urlFor('parties_id', ['ID-PARTY' => $party->id]);
            $shows = [];
            foreach ($party->shows as $show) {
                $s = $this->showService->getShow($show->id);
                $images = $s->images;
                $images = array_map(function($image) use ($routeParser) {
                    return [
                        "self" => ['href' =>$image]
                    ];
                }, $images);
                $artists = $s->artists;
                $artists = array_map(function($artist) use ($routeParser) {
                    return [
                        "id" => $artist->id,
                        "name" => $artist->name,
                        "style" => $artist->style,
                        "image" => [
                            "self" => ['href' => $artist->image]
                        ]
                    ];
                }, $artists);
                $shows[] = [
                    'id' => $s->id,
                    'title' => $s->title,
                    'date' => $s->begin,
                    'images' => $images,
                    'artists' => $artists,
                    'links' => [
                        'self' => ['href' => $routeParser->urlFor('shows_id', ['ID-SHOW' => $s->id])]
                    ]
                ];

            }
            return [
                'id' => $party->id,
                'name' => $party->name,
                'theme' => $party->theme,
                'prices' => $party->price,
                'date' => $party->date,
                'begin' => $party->begin,
                'shows' => $shows,
                'place' => [
                    'id' => $party->place->id,
                    'name' => $party->place->name,
                    'address' => $party->place->address,
                    'nb_sit' => $party->place->nbSit,
                    'nb_stand' => $party->place->nbStand,
                    'links' => [
                        'self' => ['href' => $routeParser->urlFor('places_id', ['ID-PLACE' => $party->place->id])]
                    ]
                ],
                'links' => [
                    'self' => ['href' => $urlSelf]
                ]
            ];
        }, $parties);

        $response = [
            'type' => 'ressource',
            'locale' => 'fr-FR',
            'party' => $parties,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('parties')]
            ]
        ];

        return JsonRenderer::render($rs, 200, $response);
    }
}