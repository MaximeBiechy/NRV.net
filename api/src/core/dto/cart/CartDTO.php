<?php

namespace nrv\core\dto\cart;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\dto\DTO;

class CartDTO extends DTO
{
    protected string $id, $user_id;
    protected int $price;
    protected array $tickets;
    protected int $state;

    public function __construct(Cart $card)
    {
        $this->id = $card->getId();
        $this->price = $card->getTotalPrice();
        $this->user_id = $card->getUserId();
        $this->tickets = $card->getTickets();
        $this->state = $card->getState();
    }

}