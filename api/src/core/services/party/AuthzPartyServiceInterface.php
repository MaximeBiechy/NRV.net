<?php

namespace nrv\core\services\party;

interface AuthzPartyServiceInterface
{
    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool;

}