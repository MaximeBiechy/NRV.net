<?php

namespace nrv\application\middlewares;

use nrv\core\services\place\AuthzPlaceServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzCreatePlace
{
    private AuthzPlaceServiceInterface $authzPlaceService;

    public function __construct(AuthzPlaceServiceInterface $authzPlaceService)
    {
        $this->authzPlaceService = $authzPlaceService;
    }

    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        $user = $rq->getAttribute('auth');

        $routeContext = RouteContext::fromRequest($rq) ;
        $route = $routeContext->getRoute();
        if($this->authzPlaceService->isGranted($user->id,CREATE_PLACE, null, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }

}