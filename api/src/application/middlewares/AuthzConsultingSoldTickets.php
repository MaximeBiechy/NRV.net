<?php

namespace nrv\application\middlewares;

use nrv\core\services\ticket\AuthzTicketServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzConsultingSoldTickets
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
        $user_id = $route->getArguments()['ID-USER'] ;
        if($this->authzTicketService->isGranted($user->id,CONSULTING_SOLD_TICKET, $user_id, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }

}