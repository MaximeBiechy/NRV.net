<?php

namespace toubeelib\application\middlewares;



use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Request;

class Cors
{
    public function __invoke(Request $rq, RequestHandlerInterface $next)
    {
        if (! $rq->hasHeader('Origin'))
            New HttpUnauthorizedException ($rq, "missing Origin Header (cors)");
        $rs = $next->handle($rq);
        return $rs
            ->withHeader('Access-Control-Allow-Origin', $rq->getHeader('Origin'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET' )
            ->withHeader('Access-Control-Allow-Headers','Authorization' )
            ->withHeader('Access-Control-Max-Age', '3600')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}