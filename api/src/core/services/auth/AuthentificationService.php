<?php

namespace nrv\core\services\auth;


use nrv\core\domain\entities\cart\Cart;
use nrv\core\domain\entities\user\User;
use nrv\core\dto\auth\AuthDTO;
use nrv\core\dto\auth\CredentialsDTO;
use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use nrv\core\services\ticket\TicketServiceInterface;

class AuthentificationService implements AuthentificationServiceInterface
{
    private AuthRepositoryInterface $authRepository;

    private TicketRepositoryInterface $ticketRepository;
    public function __construct(AuthRepositoryInterface $authRepository, TicketRepositoryInterface $ticketRepository)
    {
        $this->authRepository = $authRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function register(CredentialsDTO $credentials, int $role): string
    {
        try {
            $user = $this->authRepository->getUserByEmail($credentials->email);
            if ($user !== null) {
                throw new AuthentificationServiceBadDataException("User already exists");
            }
            $pass = password_hash($credentials->password, PASSWORD_DEFAULT);
            $user = new User($credentials->email, $pass, $role);
            $user_id = $this->authRepository->save($user);
            $cart = new Cart($user_id);
            $this->ticketRepository->saveCart($cart);
            return $user_id;
        } catch (RepositoryInternalServerError $e) {
            throw new AuthentificationServiceInternalServerErrorException("Error while registering user");
        } catch (RepositoryEntityNotFoundException $e) {
            throw new AuthentificationServiceNotFoundException("Error while registering user");
        }
    }

    public function byCredentials(CredentialsDTO $credentials): AuthDTO
    {
        try {
            $user = $this->authRepository->getUserByEmail($credentials->email);
            if ($user === null) {
                throw new AuthentificationServiceBadDataException("User not found");
            }
            if (!password_verify($credentials->password, $user->getPassword())) {
                throw new AuthentificationServiceBadDataException("Invalid password");
            }
            return new AuthDTO($user->getID(), $user->getEmail(), $user->getRole());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new AuthentificationServiceBadDataException("User not found");
        } catch (RepositoryInternalServerError $e) {
            throw new AuthentificationServiceInternalServerErrorException("Error while fetching user");
        }
    }

    public function getUserById(string $id): AuthDTO
    {
        try {
            $user = $this->authRepository->getUserById($id);
            return new AuthDTO($user->getID(), $user->getEmail(), $user->getRole());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new AuthentificationServiceNotFoundException("User not found");
        } catch (RepositoryInternalServerError $e) {
            throw new AuthentificationServiceInternalServerErrorException("Error while fetching user" . $e->getMessage());
        }
    }
}