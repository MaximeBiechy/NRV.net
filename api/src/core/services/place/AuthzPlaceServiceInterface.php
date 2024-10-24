<?php

namespace nrv\core\services\place;

interface AuthzPlaceServiceInterface
{
    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool;

}