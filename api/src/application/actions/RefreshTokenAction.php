<?php

namespace nrv\application\actions;

use nrv\application\provider\auth\AuthProviderBeforeValidException;
use nrv\application\provider\auth\AuthProviderInterface;
use nrv\application\provider\auth\AuthProviderSignatureInvalidException;
use nrv\application\provider\auth\AuthProviderTokenExpiredException;
use nrv\application\renderer\JsonRenderer;
use nrv\core\services\auth\AuthentificationServiceInternalServerErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;


class RefreshTokenAction extends AbstractAction
{

    private AuthProviderInterface $authProviderInterface;

    public function __construct(AuthProviderInterface $authProviderInterface)
    {
        $this->authProviderInterface = $authProviderInterface;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $token = $rq->getHeader('Authorization')[0] ?? throw new HttpUnauthorizedException($rq, 'missing Authorization Header');
            $tokenstring = sscanf($token, "Bearer %s")[0] ;

            $authDTO = $this->authProviderInterface->refresh($tokenstring);
            $res = [
                'id' => $authDTO->id,
                'email' => $authDTO->email,
                'role' => $authDTO->role,
                'token' => $authDTO->token,
                'token_refresh' => $authDTO->token_refresh
            ];
            return JsonRenderer::render($rs, 201, $res);
        } catch (AuthentificationServiceInternalServerErrorException $e) {
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        } catch (AuthProviderBeforeValidException $e) {
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        } catch (AuthProviderSignatureInvalidException $e) {
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        } catch (AuthProviderTokenExpiredException $e) {
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }
    }
}