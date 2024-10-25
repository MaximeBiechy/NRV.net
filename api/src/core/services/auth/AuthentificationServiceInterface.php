<?php

namespace nrv\core\services\auth;


use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;

interface AuthentificationServiceInterface
{
    public function register(CredentialsDTO $credentials, int $role): string;
    public function byCredentials(CredentialsDTO $credentials): AuthDTO;

    public function getUserById(string $id): AuthDTO;

}