<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayStylesAction extends AbstractAction
{
    private ShowServiceInterface $showService;

    public function __construct(ShowServiceInterface $showService)
    {
        $this->showService = $showService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $styles = $this->showService->getStyles();
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('styles');
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            'styles' => $styles,
            'links' => [
                'self' => [
                    'href' => $urlSelf
                ]
            ]
        ];
        return JsonRenderer::render($rs,200 ,$response);
    }
}