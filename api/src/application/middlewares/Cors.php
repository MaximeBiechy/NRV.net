<?php

namespace nrv\application\middlewares;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class Cors
{
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        if (!$rq->hasHeader('Origin')){
            throw new HttpUnauthorizedException($rq, 'missing Origin Header (cors)');
        }
        $rs = $next->handle($rq);
        return $rs
            ->withHeader('Access-Control-Allow-Origin', $rq->getHeader('Origin'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, PATCH' )
            ->withHeader('Access-Control-Allow-Headers','Authorization, Content-Type')
            ->withHeader('Access-Control-Max-Age', '3600')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}