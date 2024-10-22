<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\place\PlaceServiceInternalServerErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;

class DisplayPlacesAction extends AbstractAction
{
    private PlaceServiceInterface $placeServiceInterface;

    public function __construct(PlaceServiceInterface $placeServiceInterface)
    {
        $this->placeServiceInterface = $placeServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $places = $this->placeServiceInterface->getPlaces();
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('places');
            $places = array_map(function($place) use ($routeParser){
                return [
                    "id" => $place->id,
                    "name" => $place->name,
                    "address" => $place->address,
                    "nbSit" => $place->nbSit,
                    "nbStand" => $place->nbStand,
                    "images" => array_map(function($image){
                        return ['href' => $image];
                    }, $place->images),
                    "links" => [
                        "self" => ['href' => $routeParser->urlFor('places_id', ['ID-PLACE' => $place->id])]
                    ]
                ];
            }, $places);
            $response = [
                "type" => "collection",
                "locale" => "fr-FR",
                "places" => $places,
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        }catch (PlaceServiceInternalServerErrorException $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}