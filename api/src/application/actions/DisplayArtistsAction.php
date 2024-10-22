<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceInterface;
use nrv\core\services\show\ShowServiceInternalServerErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;

class DisplayArtistsAction extends AbstractAction
{
    private ShowServiceInterface $showService;

    public function __construct(ShowServiceInterface $showService)
    {
        $this->showService = $showService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $artists = $this->showService->getArtists();
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('artists');
            $artists = array_map(function($artist) use ($routeParser) {
                $urlShow = $routeParser->urlFor('artists_id', ['ID-ARTIST' => $artist->id]);
                return [
                    "id" => $artist->id,
                    "name" => $artist->name,
                    "style" => $artist->style,
                    "image" => [
                        "self" => ['href' => $artist->image]
                    ],
                    "links" => [
                        "self" => ['href' => $urlShow]
                    ]
                ];
            }, $artists);

            $response = [
                "type" => "collection",
                "locale" => "fr-FR",
                "shows" => $artists,
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        }catch (ShowServiceInternalServerErrorException $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}