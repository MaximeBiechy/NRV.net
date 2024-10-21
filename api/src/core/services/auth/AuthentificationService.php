<?php

namespace toubeelib\core\services\auth;

use toubeelib\core\domain\entities\user\User;
use toubeelib\core\dto\auth\AuthDTO;
use toubeelib\core\dto\auth\CredentialsDTO;
use toubeelib\core\dto\auth\TokenDTO;
use toubeelib\core\repositoryInterfaces\AuthRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\repositoryInterfaces\RepositoryInternalServerError;

class AuthentificationService implements AuthentificationServiceInterface
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(CredentialsDTO $credentials, int $role): string
    {
        try{
            $user = $this->authRepository->getUserByEmail($credentials->email);
            if ($user !== null) {
                throw new AuthentificationServiceBadDataException("User already exists");
            }
            $pass = password_hash($credentials->password, PASSWORD_DEFAULT);
            $user = new User($credentials->email, $pass, $role);
            return $this->authRepository->save($user);
        }catch (RepositoryInternalServerError $e){
            throw new AuthentificationServiceInternalServerErrorException("Error while registering user");
        }
    }

    public function byCredentials(CredentialsDTO $credentials): AuthDTO
    {
        try{
            $user = $this->authRepository->getUserByEmail($credentials->email);
            if ($user === null) {
                throw new AuthentificationServiceBadDataException("User not found");
            }
            if (!password_verify($credentials->password, $user->getPassword())) {
                throw new AuthentificationServiceBadDataException("Invalid password");
            }
            return new AuthDTO($user->getID(), $user->getEmail(), $user->getRole());
        }catch (RepositoryEntityNotFoundException $e){
            throw new AuthentificationServiceBadDataException("User not found");
        }catch (RepositoryInternalServerError $e){
            throw new AuthentificationServiceInternalServerErrorException("Error while fetching user");
        }
    }

}