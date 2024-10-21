<?php

namespace nrv\core\domain\entities\user;

use nrv\core\domain\entities\Entity;

class User extends Entity
{
    private string $email;
    private string $password;
    private int $role;

    public function __construct(string $email, string $password, int $role)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): int
    {
        return $this->role;
    }

}