<?php

namespace nrv\core\services\party;

use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;

class AuthzPartyService implements AuthzPartyServiceInterface
{
    private PartyRepositoryInterface $partyRepository;
    private AuthRepositoryInterface $authRepository;

    public function __construct(PartyRepositoryInterface $partyRepository, AuthRepositoryInterface $authRepository)
    {
        $this->partyRepository = $partyRepository;
        $this->authRepository = $authRepository;
    }

    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool
    {
        switch ($operation) {
            case CREATE_PARTY :
                return $role === ADMIN || $role === SUPER_ADMIN;
            default :
                return false;
        }

    }
}