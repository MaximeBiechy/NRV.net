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

class DisplayPartyAction extends AbstractAction
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
        $id = $args['ID-PARTY'];
        try {
            $party = $this->partyService->getParty($id);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
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
            $response = [
                'type' => 'ressource',
                'locale' => 'fr-FR',
                'party' => [
                    'id' => $party->id,
                    'name' => $party->name,
                    'theme' => $party->theme,
                    'prices' => $party->price,
                    'date' => $party->date,
                    'begin' => $party->begin,
                    'shows' => $shows,
                    'links' => [
                        'self' => ['href' => $urlSelf]
                    ]
                ]
            ];

            return JsonRenderer::render($rs, 200, $response);

        } catch (PartyServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (PartyServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (PartyServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}