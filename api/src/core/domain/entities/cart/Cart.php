<?php

namespace nrv\core\domain\entities\cart;

use nrv\core\domain\entities\Entity;

class Cart extends Entity
{
    protected string $user_id;
    protected int $total_price;
    protected array $tickets;
    protected int $state;

    public function __construct(string $user_id, int $total_price, array $tickets, int $state = 0)
    {
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->tickets = $tickets;
        $this->state = $state;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->total_price = $total_price;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function setTickets(array $tickets): void
    {
        $this->tickets = $tickets;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
    }

}