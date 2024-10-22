<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\provider\auth\AuthProviderInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\auth\CredentialsDTO;
use nrv\core\services\auth\AuthentificationServiceBadDataException;
use nrv\core\services\auth\AuthentificationServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class SignupAction extends AbstractAction
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
            $this->authProvider->register(new CredentialsDTO($email, $password));

            $authDTO = $this->authProvider->signin(new CredentialsDTO($email, $password));
            $res = [
                'id' => $authDTO->id,
                'email' => $authDTO->email,
                'role' => $authDTO->role,
            ];
            return JsonRenderer::render($rs, 201, $res);
        } catch (AuthentificationServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (AuthentificationServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}