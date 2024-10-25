<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceBadDataException;
use nrv\core\services\show\ShowServiceInterface;
use nrv\core\services\show\ShowServiceInternalServerErrorException;
use nrv\core\services\show\ShowServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Rfc4122\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplayShowAction extends AbstractAction
{
    private ShowServiceInterface $showServiceInterface;

    public function __construct(ShowServiceInterface $showServiceInterface)
    {
        $this->showServiceInterface = $showServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            // Vérification de l'ID UUID
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($args['ID-SHOW'])) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }

            $show = $this->showServiceInterface->getShow($args['ID-SHOW']);

            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $images = $show->images;
            $images = array_map(function($image) use ($routeParser) {
                return [
                    "self" => ['href' =>$image]
                ];
            }, $images);
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
            $show = [
                "id" => $show->id,
                "title" => $show->title,
                "date" => $show->begin,
                "images" => $images,
                "artists" => $artists,
            ];

            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "show" => $show,
                "self" => ['href' => $routeParser->urlFor('shows_id', ['ID-SHOW' => $show['id']])]
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (ShowServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (ShowServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (ShowServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}