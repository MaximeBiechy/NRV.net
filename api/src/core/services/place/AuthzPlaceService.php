<?php

namespace nrv\core\services\place;

use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\PlaceRepositoryInterface;

class AuthzPlaceService implements AuthzPlaceServiceInterface
{

    private PlaceRepositoryInterface $placeRepository;
    private AuthRepositoryInterface $authRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository, AuthRepositoryInterface $authRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->authRepository = $authRepository;
    }

    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool
    {
        switch ($operation) {
            case CREATE_PLACE :
                return $role === ADMIN || $role === SUPER_ADMIN;
            default :
                return false;
        }
    }
}