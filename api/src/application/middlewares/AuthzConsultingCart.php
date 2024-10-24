<?php

namespace nrv\application\middlewares;

use nrv\core\services\ticket\AuthzTicketServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class AuthzConsultingCart
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
        $cart_id = $route->getArguments()['ID-CART'] ;
        if($this->authzTicketService->isGranted($user->id,CONSULTING_CART, $cart_id, $user->role ))
            return $next->handle($rq);
        else
            throw new HttpForbiddenException($rq, 'Forbidden');
    }

}