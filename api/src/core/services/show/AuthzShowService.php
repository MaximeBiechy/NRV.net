<?php

namespace nrv\core\services\show;

use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;

class AuthzShowService implements AuthzShowServiceInterface
{
    private ShowRepositoryInterface $showRepository;
    private AuthRepositoryInterface $authRepository;

    public function __construct(ShowRepositoryInterface $showRepository, AuthRepositoryInterface $authRepository)
    {
        $this->showRepository = $showRepository;
        $this->authRepository = $authRepository;
    }

    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool
    {
        switch ($operation) {
            case CREATE_SHOW :
                return $role === ADMIN || $role === SUPER_ADMIN;
            default :
                return false;
        }
    }
}