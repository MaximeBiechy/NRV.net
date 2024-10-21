<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\user\User;

interface AuthRepositoryInterface
{
    public function save(User $user): string;
    public function getUserByEmail(string $email): User;
    public function getUserById(string $id): User;
    public function getUsersByRole(int $role): array;

}