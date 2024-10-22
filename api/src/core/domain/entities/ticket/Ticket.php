<?php

namespace nrv\core\domain\entities\ticket;

use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\user\User;

class Ticket extends Entity
{
    private string $name, $user_id;
    private int $price;

    public function __construct(string $name, int $price, string $user_id)
    {
        $this->name = $name;
        $this->price = $price;
        $this->user_id = $user_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


}