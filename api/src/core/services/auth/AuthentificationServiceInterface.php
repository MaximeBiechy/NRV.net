<?php

namespace toubeelib\core\services\auth;

use toubeelib\core\dto\auth\AuthDTO;
use toubeelib\core\dto\auth\CredentialsDTO;

interface AuthentificationServiceInterface
{
    public function register(CredentialsDTO $credentials, int $role): string;
    public function byCredentials(CredentialsDTO $credentials): AuthDTO;

}