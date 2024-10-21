<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\party\PartyServiceBadDataException;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\party\PartyServiceInternalServerErrorException;
use nrv\core\services\party\PartyServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplayPartyAction extends AbstractAction
{
    private PartyServiceInterface $partyService;

    public function __construct(PartyServiceInterface $partyService)
    {
        $this->partyService = $partyService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['ID-PARTY'];
        try {
            $party = $this->partyService->getParty($id);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('parties_id', ['ID-PARTY' => $party->id]);

            $response = [
                "type" => "ressource",
                "locale" => "fr-FR",
                "praticien" => $party,
                "links" => [
                    "self" => ['href' => $urlSelf]
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