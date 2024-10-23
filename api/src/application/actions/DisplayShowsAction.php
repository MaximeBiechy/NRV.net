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
        $params = $rq->getQueryParams();

        if (isset($params['date']) && strlen($params['date']) > 0 ) {
            if (isset($params['page'])){
                $shows = $this->showServiceInterface->getShowsByDatePaginated(urldecode($params['date']), $params['page'], NB_PAGES);
            } else {
            $shows = $this->showServiceInterface->getShowsByDate(urldecode($params['date']));
            }
        } else if (isset($params['style']) && strlen($params['style']) > 0) {
            if (isset($params['page'])){
                $shows = $this->showServiceInterface->getShowsByStylePaginated(urldecode($params['style']), $params['page'], NB_PAGES);
            } else {
                $shows = $this->showServiceInterface->getShowsByStyle(urldecode($params['style']));
            }
        } else if (isset($params['place']) && strlen($params['place']) > 0) {
            if (isset($params['page'])){
                $shows = $this->showServiceInterface->getShowsByPlacePaginated(urldecode($params['place']), $params['page'], NB_PAGES);
            } else {
            $shows = $this->showServiceInterface->getShowsByPlace(urldecode($params['place']));
            }
        } else {
            if (isset($params['page'])){
                $shows = $this->showServiceInterface->getShowsPaginated($params['page'], NB_PAGES);
            } else {
                $shows = $this->showServiceInterface->getShows();
            }
        }

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('shows');
        $shows = array_map(function($show) use ($routeParser) {
            $urlShow = $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id]);
            $images = $show->images;
            $images = array_map(function($image) use ($routeParser) {
                return [
                    "self" => ['href' =>$image]
                ];
            }, $images);
            return [
                "id" => $show->id,
                "title" => $show->title,
                "date" => $show->begin,
                "images" => $images,
                "links" => [
                    "self" => ['href' => $urlShow]
                ]
            ];
        }, $shows);

        $response = [
            "type" => "collection",
            "locale" => "fr-FR",
            "shows" => $shows,
            "links" => [
                "self" => ['href' => $urlSelf]
            ]
        ];
        return JsonRenderer::render($rs, 200, $response);
    }
}