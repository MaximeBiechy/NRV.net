<?php

namespace nrv\core\services\ticket;

interface AuthzTicketServiceInterface
{
    public function isGranted(string $user_id, int $operation, string $ressource_id, int $role): bool;

}