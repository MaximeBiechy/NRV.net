<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceArtistNotFoundException;
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

class DisplayArtistAction extends AbstractAction
{
    private ShowServiceInterface $showServiceInterface;

    public function __construct(ShowServiceInterface $showServiceInterface)
    {
        $this->showServiceInterface = $showServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            // Vérification de l'ID UUID
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($args['ID-ARTIST'])) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }

            $artist = $this->showServiceInterface->getArtist($args['ID-ARTIST']);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('artists_id', ['ID-ARTIST' => $artist->id]);
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "artist" => [
                    "id" => $artist->id,
                    "name" => $artist->name,
                    "style" => $artist->style,
                    "image" => [
                        "self" => ['href' => $artist->image]
                    ]
                ],
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (ShowServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (ShowServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (ShowServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (ShowServiceArtistNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}