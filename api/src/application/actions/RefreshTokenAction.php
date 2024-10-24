<?php

namespace nrv\application\actions;

use nrv\application\provider\auth\AuthProviderInterface;
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
            $token = $rq->getHeader('Authorization')[0] ?? null;
            if ($token === null) {
                return $rs->withStatus(401);
            }

            $authDTO = $this->authProviderInterface->refresh($token);
            $res = [
                $authDTO->token,
                $authDTO->refreshToken
            ];
            return JsonRenderer::render($rs, 201, $res);
        } catch (AuthentificationServiceInternalServerErrorException $e) {
            throw new HttpUnauthorizedException($rq, $e->getMessage());
        }
    }
}