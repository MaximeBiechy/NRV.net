<?php

namespace toubeelib\core\dto\auth;

use toubeelib\core\dto\DTO;

class AuthDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected int $role;
    protected ?string $token;
    protected ?string $token_refresh;

    public function __construct(string $id, string $email, int $role, string $token = null, string $token_refresh = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
        $this->token = $token;
        $this->token_refresh = $token_refresh;
    }

}