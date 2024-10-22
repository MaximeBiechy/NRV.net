<?php

namespace nrv\core\dto\card;

use nrv\core\dto\DTO;

class CardDTO extends DTO
{
    protected string $id, $name, $user_id;
    protected int $price;

    public function __construct(string $id, string $name, int $price, string $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->user_id = $user_id;
    }

}