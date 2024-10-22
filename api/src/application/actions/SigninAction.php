<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\provider\auth\AuthProviderInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\auth\CredentialsDTO;
use nrv\core\services\auth\AuthentificationServiceBadDataException;
use nrv\core\services\auth\AuthentificationServiceInternalServerErrorException;
use nrv\core\services\auth\AuthentificationServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class SigninAction extends AbstractAction
{

    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();
        if (!isset($data['email']) || !isset($data['password'])) {
            throw new HttpBadRequestException($rq, 'Missing email or password');
        }

        $email = $data['email'];
        $password = $data['password'];

        try {
            $authDTO = $this->authProvider->signin(new CredentialsDTO($email, $password));
            $res = [
                'id' => $authDTO->id,
                'email' => $authDTO->email,
                'role' => $authDTO->role,
                'token' => $authDTO->token,
                'token_refresh' => $authDTO->token_refresh
            ];
            return JsonRenderer::render($rs, 200, $res);
        } catch (AuthentificationServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (AuthentificationServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (AuthentificationServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}