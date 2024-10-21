<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
        $show = $this->showServiceInterface->getShow($args['ID-SHOW']);
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            "show" => $show,
            "links" => [
                "self" => ['href' => $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id])]
            ]
        ];
        return JsonRenderer::render($rs, 200, $response);
    }
}