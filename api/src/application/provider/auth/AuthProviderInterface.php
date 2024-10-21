<?php

namespace toubeelib\application\provider\auth;

use toubeelib\core\dto\auth\AuthDTO;
use toubeelib\core\dto\auth\CredentialsDTO;

interface AuthProviderInterface
{
    public function register(CredentialsDTO $credentialsDTO): void;
    public function signin(CredentialsDTO $credentialsDTO): AuthDTO;
    public function refresh(string $token): AuthDTO;
    public function getSignedInUser(string $token): AuthDTO;

}