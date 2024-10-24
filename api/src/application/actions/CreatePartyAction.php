<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\renderer\JsonRenderer;
use nrv\core\domain\entities\party\Party;
use nrv\core\domain\entities\place\Place;
use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\show\ShowServiceBadDataException;
use nrv\core\services\show\ShowServiceInternalServerErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Routing\RouteContext;

class CreatePartyAction extends AbstractAction
{

    private PartyServiceInterface $partyService;
    private PlaceServiceInterface $placeService;

    public function __construct(PartyServiceInterface $partyService, PlaceServiceInterface $placeService)
    {
        $this->partyService = $partyService;
        $this->placeService = $placeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $data = $rq->getParsedBody();
            $placeInputValidator = Validator::key('name', Validator::stringType()->notEmpty())
                ->key('theme', Validator::stringType()->notEmpty())
                ->key('prices', Validator::intType()->notEmpty())
                ->key('date', Validator::stringType()->notEmpty())
                ->key('begin', Validator::stringType()->notEmpty())
                ->key('shows', Validator::arrayType()->notEmpty())
                ->key('place_id', Validator::stringType()->notEmpty());
            try {
                $placeInputValidator->assert($data);
            } catch (NestedValidationException $e) {
                throw new HttpBadRequestException($rq, $e->getFullMessage());
            }
            if (filter_var($data["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["name"]) {
                throw new HttpBadRequestException($rq, "Bad data format name");
            }
            if (filter_var($data["theme"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["theme"]) {
                throw new HttpBadRequestException($rq, "Bad data format theme");
            }
            if (filter_var($data["prices"], FILTER_VALIDATE_INT) !== $data["prices"]) {
                throw new HttpBadRequestException($rq, "Bad data format prices");
            }
            if (!is_array($data["shows"])) {
                throw new HttpBadRequestException($rq, "Bad data format shows");
            }
            if (filter_var($data["place_id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["place_id"]) {
                throw new HttpBadRequestException($rq, "Bad data format place");
            }
            if (filter_var($data["date"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["date"]) {
                throw new HttpBadRequestException($rq, "Bad data format date");
            }
            if (filter_var($data["begin"], FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["begin"]) {
                throw new HttpBadRequestException($rq, "Bad data format end");
            }

            $p = $this->placeService->getPlace($data["place_id"]);
            $place = new Place($p->name, $p->address, $p->nbSit, $p->nbStand, $p->images);
            $place->setID($data["place_id"]);
            $party = new Party($data["name"], $data["theme"], $data["prices"], new \DateTimeImmutable($data["date"]), new \DateTimeImmutable($data["begin"]), $data["shows"], $place);
            $partyDto = new CreatePartyDTO($party);
            $party = $this->partyService->createParty($partyDto);

            $response = [
                'type' => 'resource',
                'locale' => 'fr-FR',
                'party' => $party
            ];
            return JsonRenderer::render($rs, 201, $response);
        } catch (ShowServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (ShowServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}