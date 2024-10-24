<?php

namespace nrv\application\middlewares;

use nrv\core\services\party\AuthzPartyServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzCreateParty
{
    private AuthzPartyServiceInterface $authzPartyService;

    public function __construct(AuthzPartyServiceInterface $authzTicketService)
    {
        $this->authzPartyService = $authzTicketService;
    }
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        $user = $rq->getAttribute('auth');

        $routeContext = RouteContext::fromRequest($rq) ;
        $route = $routeContext->getRoute();
        $ticketId = $route->getArguments()['ID-CART'] ;
        if($this->authzPartyService->isGranted($user->id,CREATE_PARTY, $ticketId, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }

}