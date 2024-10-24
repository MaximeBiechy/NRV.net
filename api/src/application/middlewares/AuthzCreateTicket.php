<?php

namespace nrv\application\middlewares;

use nrv\core\services\ticket\AuthzTicketServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzCreateTicket
{
    private AuthzTicketServiceInterface $authzTicketService;

    public function __construct(AuthzTicketServiceInterface $authzTicketService)
    {
        $this->authzTicketService = $authzTicketService;
    }
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        $user = $rq->getAttribute('auth');

        $routeContext = RouteContext::fromRequest($rq) ;
        $route = $routeContext->getRoute();
        if($this->authzTicketService->isGranted($user->id,CREATE_TICKET, null, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }

}