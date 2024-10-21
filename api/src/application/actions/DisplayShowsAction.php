<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\show\ShowServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DisplayShowsAction extends AbstractAction
{
    private ShowServiceInterface $showServiceInterface;

    public function __construct(ShowServiceInterface $showServiceInterface)
    {
        $this->showServiceInterface = $showServiceInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $shows = $this->showServiceInterface->getShows();
        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('shows');
        $shows = array_map(function($show) use ($routeParser) {
            $urlShow = $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id]);
            return [
                "title" => $show->title,
                "date" => $show->begin,
                "images" => $show->images,
                "links" => [
                    "self" => ['href' => $urlShow]
                ]
            ];
        }, $shows);

        $response = [
            "type" => "collection",
            "locale" => "fr-FR",
            "praticien" => $shows,
            "links" => [
                "self" => ['href' => $urlSelf]
            ]
        ];
        return JsonRenderer::render($rs, 200, $response);
    }
}