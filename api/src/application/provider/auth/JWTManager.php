<?php

namespace toubeelib\application\provider\auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager
{

    public function createAccessToken(array $payload): string
    {
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function createRefreshToken(array $payload): string
    {
        return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS512');
    }

    public function decodeToken(string $token): array
    {
        return (array) JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS512'));
    }

}