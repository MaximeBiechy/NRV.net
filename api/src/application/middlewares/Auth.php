<?php

namespace nrv\application\middlewares;


use nrv\application\provider\auth\AuthProviderBeforeValidException;
use nrv\application\provider\auth\AuthProviderInterface;
use nrv\application\provider\auth\AuthProviderSignatureInvalidException;
use nrv\application\provider\auth\AuthProviderTokenExpiredException;
use nrv\application\provider\auth\AuthProviderUnexpectedValueException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class Auth
{
    private AuthProviderInterface $authProvider;
    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next)
    {
        try{
            $token = $rq->getHeader('Authorization')[0] ?? throw new HttpUnauthorizedException($rq, 'missing Authorization Header');
            $tokenstring = sscanf($token, "Bearer %s")[0] ;
            $authDTO = $this->authProvider->getSignedInUser($tokenstring);
            $rq = $rq->withAttribute('auth', $authDTO);
            return $next->handle($rq);
        }catch (AuthProviderUnexpectedValueException $e){
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }catch (AuthProviderBeforeValidException $e){
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }catch (AuthProviderSignatureInvalidException $e){
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }catch (AuthProviderTokenExpiredException $e){
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }
    }

}