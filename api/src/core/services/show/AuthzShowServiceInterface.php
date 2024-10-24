<?php

namespace nrv\core\services\show;

interface AuthzShowServiceInterface
{
    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool;

}