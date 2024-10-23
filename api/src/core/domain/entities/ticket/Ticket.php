<?php

namespace nrv\core\domain\entities\ticket;

use nrv\core\domain\entities\Entity;

class Ticket extends Entity
{
    protected string $name, $party_id;
    protected int $price, $quantity;

    public function __construct(string $name, int $price, int $quantity, string $party_id)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->party_id = $party_id;
    }

    public function getPartyId(): string
    {
        return $this->party_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}