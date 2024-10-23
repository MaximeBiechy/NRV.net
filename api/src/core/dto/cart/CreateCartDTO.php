<?php

namespace nrv\core\dto\cart;

use nrv\core\dto\DTO;

class CreateCartDTO extends DTO
{
    protected string $name, $user_id;
    protected int $price;

    public function __construct(string $name, int $price, string $user_id)
    {
        $this->name = $name;
        $this->price = $price;
        $this->user_id = $user_id;
    }

}