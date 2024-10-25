<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\place\PlaceServiceBadDataException;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\place\PlaceServiceInternalServerErrorException;
use nrv\core\services\place\PlaceServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Rfc4122\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplayPlaceAction extends AbstractAction
{
    private PlaceServiceInterface $placeServiceInterface;

    public function __construct(PlaceServiceInterface $placeServiceInterface)
    {
        $this->placeServiceInterface = $placeServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            // Vérification de l'ID UUID
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($args['ID-PLACE'])) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }
            $places = $this->placeServiceInterface->getPlace($args['ID-PLACE']);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('places_id', ['ID-PLACE' => $places->id]);
            $images = $places->images;
            $images = array_map(function ($image) {
                return ['href' => $image];
            }, $images);
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "place" => [
                    "id" => $places->id,
                    "name" => $places->name,
                    "address" => $places->address,
                    "nbSit" => $places->nbSit,
                    "nbStand" => $places->nbStand,
                    "images" => $images,
                ],
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (PlaceServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (PlaceServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (PlaceServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}