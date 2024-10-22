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
            throw new HttpUnauthorizedException($rq, 'Origin header is missing');
        }

        $rs = $next->handle($rq);
        return $rs
            ->withHeader('Access-Control-Allow-Origin', $rq->getHeader('Origin'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET' )
            ->withHeader('Access-Control-Allow-Headers','Authorization' )
            ->withHeader('Access-Control-Max-Age', '3600')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}