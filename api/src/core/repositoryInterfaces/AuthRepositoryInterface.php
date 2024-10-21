<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\user\User;

interface AuthRepositoryInterface
{
    public function save(User $user): string;
    public function getUserByEmail(string $email): User;
    public function getUserById(string $id): User;
    public function getUsersByRole(int $role): array;

}