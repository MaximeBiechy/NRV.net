<?php

namespace nrv\application\middlewares;

use nrv\core\services\show\AuthzShowServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzCreateShow
{
    private AuthzShowServiceInterface $authzShowService;

    public function __construct(AuthzShowServiceInterface $authzShowService)
    {
        $this->authzShowService = $authzShowService;
    }
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        $user = $rq->getAttribute('auth');

        $routeContext = RouteContext::fromRequest($rq) ;
        $route = $routeContext->getRoute();
        if($this->authzShowService->isGranted($user->id,CREATE_SHOW, null, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }
}