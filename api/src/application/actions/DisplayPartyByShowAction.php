<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceBadDataException;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\party\PartyServiceInternalServerErrorException;
use nrv\core\services\party\PartyServiceNotFoundException;
use nrv\core\services\show\ShowServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplayPartyByShowAction extends AbstractAction
{
    private PartyServiceInterface $partyService;

    public function __construct(PartyServiceInterface $partyService)
    {
        $this->partyService = $partyService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $showId = $args['ID-SHOW'];
            $party = $this->partyService->getPartyByShow($showId);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $party = array_map(function($party) use ($routeParser) {
                $shows = [];
                foreach ($party->shows as $show) {
                    $artists = $show->artists;
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
                    $images = $show->images;
                    $images = array_map(function($image) use ($routeParser) {
                        return [
                            "self" => ['href' =>$image]
                        ];
                    }, $images);
                    $shows[] = [
                        'id' => $show->id,
                        'title' => $show->title,
                        'date' => $show->begin,
                        'images' => $images,
                        'artists' => $artists,
                        "links" => [
                            "self" => ['href' => $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id])]
                        ]
                    ];
                }
                return [
                    "id" => $party->id,
                    "name" => $party->name,
                    "theme" => $party->theme,
                    "prices" => $party->price,
                    "date" => $party->date,
                    "begin" => $party->begin,
                    "shows" => $shows,
                    "links" => [
                        "self" => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $party->id])]
                    ]

                ];
            }, $party);
            $response = [
                "type" => "collection",
                "locale" => "fr-FR",
                "party" => $party,
                "links" => [
                    "self" => ['href' => $routeParser->urlFor('shows_id_party', ['ID-SHOW' => $showId])]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        }catch (PartyServiceBadDataException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }catch (PartyServiceNotFoundException $e){
            throw new HttpNotFoundException($rq, $e->getMessage());
        }catch (PartyServiceInternalServerErrorException $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}