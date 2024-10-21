<?php

namespace toubeelib\application\provider\auth;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use toubeelib\core\dto\auth\AuthDTO;
use toubeelib\core\dto\auth\CredentialsDTO;
use toubeelib\core\services\auth\AuthentificationServiceInterface;

class JWTAuthProvider implements AuthProviderInterface
{

    private AuthentificationServiceInterface $authService;
    private JWTManager $jwtManager;

    public function __construct(AuthentificationServiceInterface $authService, JWTManager $jwtManager)
    {
        $this->authService = $authService;
        $this->jwtManager = $jwtManager;
    }

    public function register(CredentialsDTO $credentialsDTO): void
    {
        $this->authService->register($credentialsDTO, 0);
    }

    public function signin(CredentialsDTO $credentialsDTO): AuthDTO
    {
        $credentials = new CredentialsDTO($credentialsDTO->email, $credentialsDTO->password);
        $authDTO = $this->authService->byCredentials($credentials);
        $payload = [
            'aud' => 'toubeelib',
            "iat" => time(),
            "exp" => time() + 3600,
            "sub" => $authDTO->id,
            "data" => [
                "email" => $authDTO->email,
                "role" => $authDTO->role
            ]
        ];
        $jwt = $this->jwtManager->createAccessToken($payload);
        $payload['exp'] = time() + 3600 * 3;
        $jwt_refresh = $this->jwtManager->createRefreshToken($payload);
        return new AuthDTO($authDTO->id, $authDTO->email, $authDTO->role, $jwt, $jwt_refresh);
    }

    public function refresh(string $token): AuthDTO
    {
        try{
            $decoded = $this->jwtManager->decodeToken($token);
            $payload = [
                'aud' => 'toubeelib',
                "iat" => time(),
                "exp" => time() + 3600,
                "sub" => $decoded->sub,
                "data" => [
                    "email" => $decoded->data->email,
                    "role" => $decoded->data->role
                ]
            ];
            $jwt = $this->jwtManager->createAccessToken($payload);
        }catch (ExpiredException $e) {
            throw new AuthProviderTokenExpiredException('Token expired');
        }catch (SignatureInvalidException $e) {
            throw new AuthProviderSignatureInvalidException('Token signature invalid');
        }catch (BeforeValidException $e) {
            throw new AuthProviderBeforeValidException('Token not yet valid');
        }catch (\UnexpectedValueException $e) {
            throw new AuthProviderUnexpectedValueException('Token not valid');
        }
        return new AuthDTO($decoded->sub, $decoded->data->email, $decoded->data->role, $jwt, $token);
    }

    public function getSignedInUser(string $token): AuthDTO
    {
        try{
            $decoded = $this->jwtManager->decodeToken($token);
            return new AuthDTO($decoded['sub'], $decoded['data']->email, $decoded['data']->role, $token);
        }catch (ExpiredException $e) {
            throw new AuthProviderTokenExpiredException('Token expired');
        }catch (SignatureInvalidException $e) {
            throw new AuthProviderSignatureInvalidException('Token signature invalid');
        }catch (BeforeValidException $e) {
            throw new AuthProviderBeforeValidException('Token not yet valid');
        }catch (\UnexpectedValueException $e) {
            throw new AuthProviderUnexpectedValueException('Token not valid');
        }
    }
}