<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\place\CreatePlaceDTO;
use nrv\core\services\place\PlaceServiceBadDataException;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\place\PlaceServiceInternalServerErrorException;
use nrv\core\services\place\PlaceServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class UpdatePlaceAction extends AbstractAction
{
    private PlaceServiceInterface $placeService;

    public function __construct(PlaceServiceInterface $placeService)
    {
        $this->placeService = $placeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $place_id = $args['ID-PLACE'];
            $data = $rq->getParsedBody();

            $placeInputValidator = Validator::key('name', Validator::stringType()->notEmpty())
                ->key('address', Validator::stringType()->notEmpty())
                ->key('nbSit', Validator::intType()->notEmpty())
                ->key('nbStand', Validator::intType()->notEmpty())
                ->key('images', Validator::arrayType()->notEmpty());
            try {
                $placeInputValidator->assert($data);
            } catch (NestedValidationException $e) {
                throw new HttpBadRequestException($rq, $e->getFullMessage());
            }
            if (filter_var($data["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["name"]) {
                throw new HttpBadRequestException($rq, "Bad data format name");
            }
            if (filter_var($data["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["address"]) {
                throw new HttpBadRequestException($rq, "Bad data format address");
            }
            if (filter_var($data["nbSit"], FILTER_VALIDATE_INT) !== $data["nbSit"]) {
                throw new HttpBadRequestException($rq, "Bad data format nbSit");
            }
            if (filter_var($data["nbStand"], FILTER_VALIDATE_INT) !== $data["nbStand"]) {
                throw new HttpBadRequestException($rq, "Bad data format nbStand");
            }
            if (!is_array($data["images"])) {
                throw new HttpBadRequestException($rq, "Bad data format images");
            }

            $placeDto = new CreatePlaceDTO($data['name'], $data['address'], $data['nbSit'], $data['nbStand'], $data['images']);
            $place = $this->placeService->updatePlace($place_id, $placeDto);

            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('update_place_id', ['ID-PLACE' => $place->id]);
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                'place' => $place,
                'links' => [
                    'self' => $urlSelf
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (PlaceServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (PlaceServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (PlaceServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}